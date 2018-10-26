(() => {
  return {

    data(){
      return {
        orientation: 'horizontal',
        classOrientation: 'fas fa-arrows-v',
        selected: false,
        currentMenu:'',
        oldRootMenu:'',
        rootPermission: this.source.id_permission,
        //id options menus conteiner
        id_parent: this.source.id_parent,
        id_default: this.source.id_default,
        list: this.source.listMenu,
        root: this.source.root,
        //info node at click for context menu
        node: null,
        droppables: [],
        idxListMenu: -1,
        nameSection: "",
        emptyMenuCurrent: null,
        viewButtonAlias: false,
        formData:{
          create: false
        },
        iconDefault: 'fas fa-cog'
      }
    },
    computed: {
      //Always updated list of menus visible on the dropdown
      listMenu(){
        let menus = [];
        if ( this.list && this.list.length ){
          for ( let ele of this.$data.list ){
            if ( (ele.code !== "shortcuts")  ){
              menus.push({
                text: ele.text,
                value: ele.id
              });
            }
          };
        }
        return menus
      },
      showArrows(){
        if( this.listMenu.length > 2 ){
          return true
        }
        return false
      },
      //Current name of the selected menu from the dprodown list
      nameMenu(){
        let name = "";
        if ( this.currentMenu !== "" ){
          for ( let ele of this.listMenu ){
            if ( ele.value === this.currentMenu ){
              name = ele.text;
            }
          }
        }
        return name
      }
    },
    methods: {
      /*changePermission(){
        bbn.fn.log(arguments);
      },*/

      /** CONTEXTMENU **/
      // Returns an array for the context menu of the menu tree (right splitter)
      contextMenu(){
        let ctx =  [
          //for delete
          {
            icon: 'far fa-trash-alt',
            text: bbn._('Delete'),
            command: node => {
              this.node = node;
              //params: id node , text node, false for define that is not menu
              this.deleteElement(node.data.id , node.text, false);
            }
          },
          //for rename section
          {
            icon: 'fas fa-pencil-alt',
            text: bbn._('Rename'),
            command: node => {
              this.node = node;
              this.renameElement(true, node.data.id, node.text, false, node.icon);
            }
          }
        ];
        if ( arguments[0].data.id_alias === null ){
          //for create sub-section
          ctx.unshift({
              icon: 'fas fa-level-down-alt',
              text: bbn._('Sub-section'),
              command: node => {
                this.node = node;
                this.addTempNode(node, {
                  text: 'New Section',
                  id_parent: node.data.id,
                  id_alias: null,
                  icon: this.iconDefault,
                  numChildren: 0
                });
                //this.createSection(node.data.id);
              }
            });
          //for create a link
          ctx.unshift({
            icon: 'fas fa-link',
            text: bbn._('New link'),
            command: node => {
              this.node = node;
              if ( node.data.id_alias === null){
                let obj = {
                  text: 'My text',
                  id_parent: node.data.id,
                  id_alias: 1,
                  icon: this.iconDefault,
                }
                this.addTempNode(node, obj)
              }
            }
          });
          ctx.push({
            icon: 'fas fa-copy',
            text: bbn._('Copy to'),
            command: node => {
              this.copyTo(node);
            }
          });
        }
        return ctx
      },

      /**METHODS FOR BUTTONS ACTIONS IN THE TOP SPLITER LEFT **/
      // for change orientatio spliter
      /*clickOrientation(){
        if ( this.orientation == "horizontal" ){
          console.log(this.orientation);
          this.$nextTick(() =>{
            this.orientation = 'vertical';
          });

          console.log(this.orientation);

          this.classOrientation = 'fas fa-arrows-h';
        }
        if( this.$data.orientation === 'vertical' ){
          this.$nextTick(() =>{
            this.$data.orientation = "horizontal";
          });

          this.classOrientation = 'fas fa-arrows-v';
        }
      },*/
      clickCreateMenu(){
        this.createMenu(this.id_parent);
      },
      clickCopyMenu(){
        this.copyMenu(this.id_parent);
      },
      clickCreateSection(){
       this.addTempNodeInRoot({
         text: 'New Section',
         id_parent: this.currentMenu,
         id_alias: null,
         icon: 'fas fa-cogs',
         numChildren: 0
       });
      },
      clickDeleteMenu(){
        this.deleteElement(this.currentMenu, this.nameMenu, true);
      },
      clickRenameMenu(){
        this.renameElement(false, this.currentMenu, this.nameMenu, this.id_parent);
      },
      clickCreateLink(){
        this.addTempNodeInRoot({
          text: 'New text',
          id_parent: this.currentMenu,
          id_alias: 1,
          icon: this.iconDefault,
          numChildren: 0
        });
      },
      clickPrev(){
        this.selected = false;
        this.idxListMenu--;
        if ( this.idxListMenu === -1 ){
          this.idxListMenu = this.list.length -1;

        }
        /*if( this.idxListMenu === 1  ){
          this.idxListMenu = 0;
        }*/
        if( this.idxListMenu <= this.list.length - 1 ){
          setTimeout(() =>{
            this.currentMenu = this.list[this.idxListMenu]['id'];
          }, 100);
        }
      },
      clickNext(){
        //this.viewButtonAlias = false;
        this.selected = false;

        this.idxListMenu++;
        if ( this.idxListMenu > this.list.length - 1  ){
          this.idxListMenu = 0;
        }
       /* else{
          if( this.idxListMenu === 1 ){
            this.idxListMenu = 2;
          }
        }*/
        if( this.idxListMenu <= this.list.length - 1 ){
          setTimeout(() => {
            this.currentMenu = this.list[this.idxListMenu]['id'];
          }, 100);
        }
      },

      /** ##ACTIONS **/

      //this method is invoked when you have to open an action popup, which one is receiving the information of the requested action.
      actionedPopUp(component, title, cfg , popup){
        bbn.vue.closest(this, ".bbns-tab").$refs.popup[0].open({
          width: popup.width,
          height: popup.height,
          title: title,
          component: component,
          source: cfg
        });
      },
      //method that informs the actionedPopup of everything that will require the action copy including its component
      copyMenu(id_parent){
        let dim = {
          width: 300,
          height: 180
        };
        if ( this.currentMenu !== "" ){
          let cfg = {
            root: this.$data.root,
            titleMenu: this.nameMenu,
            id: this.currentMenu,
            id_parent: id_parent
          };
          this.actionedPopUp('appui-menu-popup-copy_menu', bbn._('Copy menu'), cfg, dim);
        }
      },
      copyTo(node){
        let dim = {
          width: 300,
          height: 180
        };
        if ( this.currentMenu !== "" ){
          let cfg = {
            root: this.source.root,
            name: node.data.text,
            listMenu: this.listMenu,
            id: node.data.id
          };
          this.actionedPopUp('appui-menu-popup-copy_to', bbn._('Copy to'), cfg, dim);
        }
      },
      //(true, node.data.id, node.text, false, node.icon
      renameElement(ctx, current, text, id_parent, icon= false){
        let dim = {
          width: 300,
          height: 220
        };
        if ( this.currentMenu !== "" ){
          let cfg = {
            root: this.root,
            titleMenu: text,
            idMenu: current,
            //information to understand whether we are renaming a menu or section
            menu: !ctx,
            id_parent: id_parent,
            icon: icon,
          }
          let title = bbn._('Rename');
          this.actionedPopUp('appui-menu-popup-rename', title, cfg, dim);
        }
      },
      //method that informs the actionedPopup of everything that will require the action of creating a new menu, including its component
      createMenu(id){
        let dim = {
          width: 300,
          height: 180
        };
        //source for create menu
        let cfg = {
          root: this.$data.root,
          id_parent: id,
        };
        this.actionedPopUp('appui-menu-popup-new_menu', bbn._('Create new menu'), cfg, dim);
      },

      //function that asks for confirmation of cancellation of menu or sub-menu in case of successful outcome of confirm
      // it performs the action, the ctx parameter is used to understand if the request has occurred at the click of the context menu.
      deleteElement(idDelete, text, menu){
        //checks if it has an id to make sure that you perform the delete action and that anyway this id is not that of the default menu
        if ( idDelete ){
          if ( idDelete === this.id_default ){
            appui.error( bbn._("The main menu cannot be deleted !!") );
            return;
          }
          appui.confirm(
            bbn._('Secure to delete: "') + text + '" ?',
            () => {
              bbn.fn.post(
                this.root + "actions/delete_element",
                {
                  id: idDelete,
                  id_default: this.id_default,
                  id_parent: menu ? this.id_parent : this.node.data.id_parent
                },
                (d) => {
                  if ( d.success ){
                    //If ctx is set to true then you are deleting a node and not a parent menu selected from the list then you are
                    // doing a refresh with complete action to give the free of the updated menu.
                    //case delete menu
                    if ( menu ){
                      //the computed and on this property through which computed allows me to update the menu list
                      // in the dropdown
                      this.list = d.listMenu.length ? d.listMenu : [];
                      //returns to the initial state
                      if ( this.currentMenu == idDelete ){
                        setTimeout(() => {
                          this.currentMenu = this.list[this.list.length-1]['id'];
                          this.idxListMenu --;
                        }, 100);
                      }
                    }
                    //case delete node of a tree menu
                    else{
                      //case level at 0, modify items whitout reload
                      /*if ( this.node.level === 0 ){
                        for ( let i in this.node['parent']['items'] ){
                          if ( idDelete === this.node['parent']['items'][i]['id'] ){
                            idx = i;
                          }
                        }
                        if ( idx !== false ){
                          this.node['parent']['items'].splice(idx, 1);
                        }
                      }
                      else {
                        appui.menu.reloadTreeOfNode();
                        let treeNode = bbn.vue.closest(this.node, "bbn-tree-node");
                        if ( treeNode.numChildren === 1 ){
                          treeNode.numChildren = 0;
                        }
                      }*/
                      if ( this.node !== null ){
                        bbn.fn.each( this.node['parent']['items'], (val, i)=>{
                          if ( idDelete === this.node['parent']['items'][i]['id'] ){
                            this.node['parent']['items'].splice(i, 1);
                            this.node = null;
                            return false;
                          }
                        });
                      }
                    }
                    appui.success( bbn._("Deleted correctly !!") );
                  }
                  else{
                    appui.error( bbn._("Error, not cleared correctly!!") );
                  }
                }
              );
            }
          )
        }
      },
      addTempNode(node, cfg){
        node.isExpanded = true;
        if ( node ){
          if( !node.numChildren ){
            this.$nextTick(() =>{
              node.numChildren = node.numChildren + 1;
            });
          }
          setTimeout(()=>{
            this.$nextTick(() => {
              node.$refs.tree[0].isLoaded= true;
            });
            this.formData.create = true;
            node.$refs.tree[0].items.push(cfg);
            setTimeout(()=>{
              node.$refs.tree[0].$children[node.$refs.tree[0].items.length - 1].isSelected = true;
            }, 150);
          }, 600);
        }
      },
      addTempNodeInRoot(cfg){
        let tree = this.$refs.menus;
        if ( tree ){
          tree.items.push(cfg);
          tree.$forceUpdate();
          this.emptyMenuCurrent = false;
          this.formData.create = true;
          this.$nextTick(() =>{
            tree.$children[0].$children[tree.$children[0].$children.length - 1].isSelected = true;
          });
        }
        this.node = tree
      },
      //for form left
      openListIcons(){
        appui.$refs.tabnav.activeTab.getPopup().open({
          width: '80%',
          height: '80%',
          title: bbn._('Select icons'),
          component: 'appui-core-popup-iconpicker',
          source: {
            obj: appui.menu.selected,
            field: 'icon'
          }
        });
      },
      // If the three-menu has been opened then it will update the component date again.
      reloadTreeMenu(){
        if ( appui.$refs.menu.hasBeenOpened ){
         //update three-menu component
          appui.$refs.menu.hasBeenOpened = false;
          this.$nextTick(() =>{
            appui.$refs.menu.$refs.tree.isLoaded = false
          });
        }
      },
      moveNode(e, node, dest){
        bbn.fn.post(this.root + 'actions/move', {
          id: node.data.id,
          id_parent: dest.data.id
        }, d => {
          if( d.success ){
            appui.success(bbn._('Successfully moved!!'));
          }
          else{
            appui.error(bbn._('Error moved!!'));
          }
          dest.$refs.tree[0].reload();
          if ( dest.$refs.tree[0] !== node.parent ){
            node.parent.reload();
          }
        });
      },
      //reload sub tree
      reloadTreeOfNode(){
        if( this.node != null ){
          let treeOfNode = bbn.vue.closest(this.node, 'bbn-tree');
          treeOfNode.reload();
        }
      },
      successEditionMenu(d){
        this.formData.create= false;
        if( d.success ){
          setTimeout(()=>{
            this.selected= false;
            this.node.isSelected= false;
          }, 500);

          if( d.create  === true ){
            appui.success( bbn._("Successfully create !!" ));
            this.emptyMenuCurrent = false;
          }
          if( d.create === false ){
            appui.error(bbn._("Error create"));
          }
          if ( d.id ){
            appui.success( bbn._("Successfully edit!!" ));
          }
          /*setTimeout(()=>{
            this.$refs.menus.reload();
          },400);*/
        }
        else{
          appui.error(bbn._("Error!"));
        }
        //this.reloadTreeMenu();
        if ( this.node.parent.level === 0 && d.params ){

          let id = this.node['parent']['items'].length -1;

          $.each(d.params, (i, v)=>{
            this.node.$set(this.node['parent']['items'][id], i, v);
          });

        }
        else{

          this.reloadTreeOfNode();
        }
      },
      selectMenu(tree){
        /*if ( tree.data.id_alias === null ){
          this.viewButtonAlias = true;
        }*/
        this.node = tree;
        this.selected = false;
        this.$nextTick(() => {
          this.selected = {
            level: tree.level,
            text: tree.text,
            icon: tree.icon,
            num: tree.num,
            numChildren: tree.numChildren,
            id: tree.data.id,
            id_parent: tree.data.id_parent,
            id_alias: tree.data.id_alias,
            path: tree.data.path !== undefined ? tree.data.path : [],
            isExpanded: tree.isExpanded,
            isActive: tree.isActive,
            isMounted: tree.isMounted,
            isSelected: tree.isSelected,
            parentIsRoot: tree.parent.level === 0
          };
          if( tree.data.argument !== undefined ){
            this.selected.argument = tree.data.argument;
          }
          if ( this.$refs.form ){
            this.$refs.form.reinit();
          }
        });
      },
      selectPermission(node){
        this.$set(this.selected, "path", node.getPath());
        this.$set(this.selected, "id_alias", node.data.id);
      },
      formCancel(){
        if ( this.formData.create ){
          this.selected= false;

          setTimeout(()=>{
            this.$refs.menus.reload();
          },400);

          this.formData.create= false;
        }
        if ( this.$refs.treePermission ){
          this.$refs.treePermission.$emit('pathChange');

        }
        bbn.fn.log("formCancel", this.$refs.treePermission);
      },
      /** MAPPER OF TREE **/
      //menu tree mapper
      mapMenu(a){
        return {
          data: a,
          id: a.id,
          id_parent: a.id_parent,
          id_alias: a.id_alias,
          path: a.path || [],
          icon: a.icon,
          text: a.text,
          argument: a.argument,
          num: a.num_children || 0
        }
      },
      getPermissionsContext(node){
        let res = [];
        if ( node.icon === 'fas fa-file' ){
          res.push({
            text: 'Go',
            icon: 'far fa-hand-right',
            command(node){
              let path = node.getPath();
              bbn.fn.post('options/permissions', {
                id: node.data.id,
                full: 1
              }, (d) =>{
                bbn.fn.link(d.data.path);
              });
            }
          });
        }
        return res;
      },
      //Permitted tree mapper
      mapPermissions(a){
        a.text += ' &nbsp; <span class="bbn-grey">' +  "(" + a.code +  ")" + '</span>';
        return $.extend({selectable: a.icon === 'fas fa-file'}, a);
      },
      /** ##DRAG & DROP  **/

      /**
       * FOR MENU SPLITER LEFT
       */

      ctrlStartDrag(){
        bbn.fn.log("STArt DRAG", this, arguments);
        /* let node = arguments[0],
         event = arguments[1];
         if( (node.items.length) && (node.numChildren > 0) || (node.icon === 'fas fa-key') ){
         event.preventDefault();
         }*/
      },
      ctrlEndDrag(){
        bbn.fn.log("END DRAG",  arguments[0]);
        let node = arguments[0],
            event = arguments[1];
        /*
         if( (!node.items.length) && (node.numChildren === 0) && (node.icon !== 'fas fa-key') ){
         event.preventDefault();
         }
         */
      },
      /**
       *  FOR MENUS SPLITER RIGHT
       */
      ctrlStartDragMenus(node){
        bbn.fn.warning("START");
        bbn.fn.log(node, node.data, node.data.id_parent);
        //acquire the id of the node we want to move
        //this.idStartMove = node.data.id;
      },
      //activates when the node to be moved is released, it performs checks and, if necessary, performs the displacement action
      ctrlEndDragMenus(node, ev, destination){
        //The node shifts can do so all except the default menu that reside in the right splitter.

        if ( this.currentMenu !== this.id_default ){
          //acquire the id of the node that will contain that one we want to move

          bbn.fn.warning("end");
          bbn.fn.log(arguments, node, node.data,  node.data.id_parent, destination, ev);

          if ( node.data.code ){
            bbn.fn.post(this.root + 'actions/create_shortcut', {
              code: node.data.code,
              source: node.data.id,
              destination: destination.data.id
            })
          }

          else if ( node.data.id !== destination.data.id ){

            bbn.fn.post(this.root + "actions/move_menu", {
                id: node.data.id,
                id_parent: destination.data.id
              }, (d) => {
                if ( d.success ){

                  setTimeout( () => {
                    let tree = bbn.vue.find(destination, 'bbn-tree');
                    tree.reload();
                  }, 800);

                  appui.success("It has been moved correctly");
                }
                else{
                  appui.error("It has not been moved correctly");
                }
              }
            );
          }
        }
      },
      test1(){
        bbn.fn.log("TEST FROM TREE 1", arguments[0]);

      },
      test2(){
        bbn.fn.warning("start")
        bbn.fn.log("TEST FROM TREE 2 START", arguments);
      },
      test3(){
        bbn.fn.warning("OVER")
        bbn.fn.log("TEST FROM TREE 2 OVER", arguments);
      },
    },

    watch:{
      /*
       * @watch currentMenu
       *
       * @set
       */
      currentMenu(val, old){
        for ( let i in this.list ){
          if ( this.list[i]['id'] === val ){
            this.idxListMenu = parseInt(i);
            this.emptyMenuCurrent = this.list[i]['num_children'] == 0;
          }
        }
        //keep track of the previous root
        this.oldRootMenu = old;
        if ( old && !val ){
          this.droppables.pop();
        }
        if ( !old && val ){
          this.$nextTick(() => {
            this.droppables.push(this.$refs.menus);
          });
        }
        else{
          this.$refs.menus.reload();
        }
        //Being that templete does not recharge at id change then we make a tree reload so we have the right menu
      },
    },
    mounted(){
      if ( this.$refs.menus ){
        this.droppables.push(this.$refs.menus);
      }
    },
    created(){
      appui.menu = this;
    }
  }
})();
