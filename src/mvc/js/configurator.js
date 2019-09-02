(() => {
  return {
    /**
     * [data initial]
     * @return {object}
     */
    data(){
      return {
        treeMenuData:{
          id_menu: this.source.listMenu[0]['value'],          
          id_parent: null,
          path: []
        },
        //for  orientation spitter
        orientation: 'horizontal',
        classOrientation: 'nf nf-fa-arrows_v',
        selected: false,
        currentMenu: '',
        oldRootMenu: null,
        rootPermission: this.source.id_permission,
        //id options menus conteiner
        id_parent: this.source.id_parent,
        id_default: this.source.id_menu_default,
        list: this.source.listMenu,
        root: this.source.root,
        //info node at click for context menu
        node: null,
        idxListMenu: 0,
        nameSection: '',
        emptyMenuCurrent: null,
        viewButtonAlias: false,
        formData:{
          create: false,
          menu_default: this.source.id_menu_default
        },
        iconDefault: 'nf nf-fa-cog',
        elementMove: false,
        showOrderUp: false,
        showOrderDown: false,
      }
    },
    computed: {
      disabledAction(){
        if ( ((!!this.infoMenu.public === true) &&
          (appui.app.user.isDev || appui.app.user.isAdmin))  ||
          (!!this.infoMenu.public === false)
        ){
          return false;
        }
        else{
          return true;
        }
      },
      infoMenu(){
        let id = bbn.fn.search(this.source.listMenu, 'value', this.treeMenuData.id_menu);
        if ( id > -1 ){
          return this.source.listMenu[id];
        }
        return {}
      },
      /**
       * check if there are more menus if it returns true the arrows will appear to scroll through the list
       *
       * @computed showArrows
       * @return {Boolean}
       */
      showArrows(){
        if( this.source.listMenu.length > 1 ){
          return true
        }
        return false
      },
      /*
       * Get Current name of the selected menu from the dprodown list
       *
       * @computed nameMenu
       * @return {String}
       */
      nameMenu(){
        let name = "";
        if ( this.treeMenuData.id_menu !== "" ){
          name = bbn.fn.get_field(this.source.listMenu, 'value', this.treeMenuData.id_menu, 'text');
        }
        return name
      }
    },
    methods: {
      makeDefault(){
        alert("default")
      },
      /*
       * function that sorts element by increasing or decreasing one position at a time
       *
       * @method orderEeemnt
       *
       * @param orderEle {String} parameter that defines whether the element must go up or down
       */
      orderElement(orderEle){
        let items = bbn.vue.closest(this.elementMove,'bbn-tree').items,
            id =  bbn.fn.search(bbn.vue.closest(this.elementMove,'bbn-tree').items, 'id', this.elementMove.data.id),
            move = orderEle === 'up' ? id-1 : id+1,
            order= false,
            i = false,
            idx = this.elementMove.data.id;
        if ( (items[id] !== undefined) && (items[move] !== undefined) ){
          //no root
          if ( this.elementMove.level > 0 ){
            //up order
              if ( orderEle === 'up' ){
               i = bbn.fn.search(bbn.vue.closest(this.elementMove,'bbn-tree').$children, 'data.id' , this.elementMove.data.id);
               order = bbn.vue.closest(this.elementMove, 'bbn-tree').$children[i-1].data.order;
              }
            //down order
             else{
               i = bbn.fn.search(bbn.vue.closest(this.elementMove,'bbn-tree').$children, 'data.id' , this.elementMove.data.id);
               order = bbn.vue.closest(this.elementMove, 'bbn-tree').$children[i+1].data.order;
             }
          }//root
          else{
            if ( orderEle === 'up' ){
              i = bbn.fn.search(this.elementMove.closest('bbn-tree').findAll('bbn-tree-node'), 'data.id' , this.elementMove.data.id);
               order = bbn.vue.closest(this.elementMove,'bbn-tree').$children[0].$children[i-1].data.order;
               bbn.fn.log("MOVE UP", i, bbn.vue.closest(this.elementMove,'bbn-tree').$children[0].$children[i-1], order)

            }
           else{
             i = bbn.fn.search(this.elementMove.closest('bbn-tree').findAll('bbn-tree-node'), 'data.id' , this.elementMove.data.id);
             bbn.fn.log("MOVE DOWN", i, bbn.vue.closest(this.elementMove,'bbn-tree').$children[0].$children[i+1])

              order = bbn.vue.closest(this.elementMove,'bbn-tree').$children[0].$children[i+1].data.order;
            }
          }
          bbn.fn.post(this.root + 'actions/order', {
            id: items[id].id,
            id_parent: items[id].id_parent,
            id_menu: this.treeMenuData.id_menu,
            num: order === 0 ? 1 : order
          }, d =>{
              if( d.success ){
                this.elementMove.parent.isLoaded = false;
                this.$set(this.elementMove.parent, 'items', []);
                let arr =[]
                bbn.fn.each(d.menu , (a, i)=>{
                  arr.push(this.mapMenu(a));
                });
                this.$nextTick(()=>{
                 this.$set(this.elementMove.parent, 'items', arr);
                   if ( this.elementMove.parent.items.length ){
                      this.elementMove.parent.isLoaded = true;
                      this.$nextTick(()=>{
                        let v = -1;
                        if ( this.elementMove.parent.isLoaded === true){
                          if ( this.elementMove.parent.level > 0 ){
                            setTimeout(()=>{
                              v = bbn.fn.search(this.elementMove.parent.$children, 'data.id' ,this.elementMove.data.id);
                              this.elementMove.parent.$children[v].isSelected = true;
                            }, 500);
                          }
                          else{
                            v = bbn.fn.search(this.elementMove.parent.$children[0].$children, 'data.id' ,idx);
                            this.elementMove.parent.$children[0].$children[v].isSelected = true;
                          }
                        }
                      });
                    }
                });

              appui.success( bbn._("Ordered successfully") + '!!')
            }
            else{
              appui.error( bbn._("Error in ordering"))
            }
          });
        }
      },
      /*
       * call method orderELement for move the element up one position
       *
       * @method moveUp
       * @fires oredrElement
       */
      moveUp(){
        this.orderElement('up');
      },
      /*
       * call method orderELement for go down the item one position
       *
       * @method moveUp
       * @fires oredrElement
       */
      moveDown(){
        this.orderElement('down');
      },
      /** CONTEXTMENU **/
      /*
       * Returns an array for the context menu of the menu tree (right splitter)
       *
       * @method contextMenu
       * @fires deleteElement
       * @fires renameElement
       * @fires addTempNode
       * @fires copyTo
       */
      contextMenu(){
        let ctx =[];
        if ( this.disabledAction === false ){
          ctx =  [
            //for delete
            {
              icon: 'nf nf-fa-trash',
              text: bbn._('Delete'),
              command: node => {
                this.node = node;
                //params: id node , text node, false for define that is not menu
                this.deleteElement(node.data.id , node.text, false);
              }
            },
            //for rename
            {
              icon: 'nf nf-mdi-lead_pencil',
              text: bbn._('Rename'),
              command: node => {
                this.node = node;
                this.selectMenu(node);
              //  this.renameNode = true;
                //this.renameElement(false, node.data.id, node.text, false, node.icon);
              }
            }
          ];
          //case context in section menu
          if ( (arguments[0].data.id_option === null) ){
            // if node is sectiom transform to link
            if ( arguments[0].num === 0 ){
              ctx.push({
                icon: 'nf nf-custom-elm',
                text: bbn._('Transform to link'),
                command: node => {
                  this.selectMenu(node);
                  this.$nextTick(()=>{
                    this.selected.id_option = 1
                  });
                }
              });
            }
            //adds the possibility of create sub-section
            ctx.unshift({
              icon: 'nf nf-fa-level_down',
              text: bbn._('Sub-section'),
              command: node => {
                this.node = node;
                this.addTempNode(node, {
                  text: bbn._('New Section'),
                  id_parent: node.data.id,
                  id_option: null,
                  icon: this.iconDefault,
                  numChildren: 0
                });
              }
            });
            //adds the possibility of create a link
            ctx.unshift({
              icon: 'nf nf-fa-link',
              text: bbn._('New link'),
              command: node => {
                this.node = node;
                if ( node.data.id_option === null){
                  let obj = {
                    text: bbn._('My text'),
                    id_parent: node.data.id,
                    id_option: 1,
                    icon: this.iconDefault,
                  }
                  this.addTempNode(node, obj)
                }
              }
            });
          }
          else{
            //convert the link menu in section menu
            ctx.push({
              icon: 'nf nf-custom-elm',
              text: bbn._('Transform to section'),
              command: node => {
                this.selectMenu(node);
                this.$nextTick(()=>{
                  this.selected.id_option = null;
                });
              }
            });
          }
        }
        //adds the possibility of copy the section to another menu
        ctx.push({
          icon: 'nf nf-fa-copy',
          text: bbn._('Copy to'),
          command: node => {
            let cfg = {
              text: node.text,
              id: node.data.id,
              menu_node:  node.data.id_menu,
              ctx: true
            };

            this.copyTo(cfg);
          }
        });
        return ctx
      },
      /**METHODS FOR BUTTONS ACTIONS IN THE TOP SPLITER LEFT **/

      /*
       * Create a new menu, this is operated by the top-bar button "create menu"
       *
       * @method createMenu
       *
       * @fires actionedPopUp
       */
      createMenu(){
        let dim = {
          width: 300,
          height: 180
        },
          //source for create menu
        cfg = {
          root: this.root,
          id_parent: this.id_parent,
        };
        //this method returns a popup with the component that we call in the first parameter
        this.actionedPopUp('appui-menu-popup-new_menu', bbn._('Create new menu'), cfg, dim);
      },
      /*
       * Copy a menu, this is operated by the top-bar button "copy menu"
       *
       * @method copyMenu
       *
       * @fires actionedPopUp
       */
      copyMenu(){
        if ( this.treeMenuData.id_menu !== "" ){
          let dim = {
            width: 300,
            height: 180
          },
          cfg = {
            root: this.$data.root,
            titleMenu: this.nameMenu,
            id: this.treeMenuData.id_menu,
            id_parent: this.id_parent
          };
          this.actionedPopUp('appui-menu-popup-copy_menu', bbn._('Copy menu'), cfg, dim);
        }
      },
      /*
       * Temporarily adds a new section in root this is operated by the top-bar button "Copy menu"
       *
       * @method createSection
       *
       * @fires addTempNodeInRoot
       */
      createSection(){
      // add temporaney node in tree
       this.addTempNodeInRoot({
         text: bbn._('New Section'),
         id_parent: null,
         id_option: null,
         icon: 'nf nf-fa-cogs',
         numChildren: 0
       });

      },
      /*
       * Delete current menu this is operated by the top-bar button "Delete menu"
       *
       * @method deleteMenu
       *
       * @fires deleteElement
       */
      delMenu(){
        //passes the parameters of the current menu for delete
        this.deleteElement(this.treeMenuData.id_menu, this.nameMenu, true);
      },
      /*
       * Rename current menu this is operated by the top-bar button "Rename menu"
       *
       * @method renameMenu
       *
       * @fires renameElement
       */
      renameMenu(){
        //passes the parameters of the current menu for rename
        this.renameElement(true, this.treeMenuData.id_menu, this.nameMenu, this.id_parent);
      },
      /*
       * Create a new link in root of  current menu  set id_alias at 1 this is operated by the top-bar button "Create link"
       *
       * @method createLink
       *
       * @fires addTempNodeInRoot
       */
      createLink(){
        // add temporaney node in tree of the root menu with id_alias at 1 for create a link
        this.addTempNodeInRoot({
          text: bbn._('New text'),
          id_parent: null,
          id_option: 1,
          icon: this.iconDefault,
          numChildren: 0
        });
      },
      /*
       * Copy the current menu and assign it to the root of another selected menu this is operated by the top-bar button "Copy menu to"
       *
       * @method copyMenuTo
       *
       * @fires copyto
       */
      copyMenuTo(){
        //accepts as parameter an object with id of the menu to be copied and where to copy it
        this.copyTo({
          text:this.nameMenu,
          id: this.treeMenuData.id_menu
        });
      },
      /*
       * Allows backward scrolling of the menu list one by one  this is operated by the top-bar button "back menu"
       *
       * @method prevMenu
       */
      prevMenu(){
        this.selected = false;
        this.idxListMenu--;
        //get last of the list if click at first of the list
        if ( this.idxListMenu === -1 ){
          this.idxListMenu = this.list.length -1;

        }
        if( this.idxListMenu <= this.list.length - 1 ){
          setTimeout(() =>{
            this.treeMenuData.id_menu = this.list[this.idxListMenu]['value'];
          }, 100);
        }
      },
      /*
       * Allows forward scrolling of the menu list, one by one  this is operated by the top-bar button "Next menu"
       *
       * @method nextMenu
       */
      nextMenu(){
        this.selected = false;
        this.idxListMenu++;
        if ( this.idxListMenu > this.list.length - 1  ){
          this.idxListMenu = 0;
        }
        if( this.idxListMenu <= this.list.length - 1 ){
          setTimeout(() => {
            this.treeMenuData.id_menu = this.list[this.idxListMenu]['value'];
          }, 100);
        }
      },
      /** ##ACTIONS **/

      /*
       * This method is invoked when you need to open an action pop-up, which receives the information to perform the requested action.
       *
       * @method actionedPopUp
       * @param {String} componet name of the component to include in the popup
       * @param {String} title  title popup
       * @param {Object} cfg source of the component we include
       * @param {Object} popup dimension poup ( width and height )
       */
      actionedPopUp(component, title, cfg , popup){
        this.closest("bbn-container").getPopup().open({
          width: popup.width,
          height: popup.height,
          title: title,
          component: component,
          source: cfg
        });
      },
      /*
       * Based on where is called, copy section or memu and  put in another root menu
       *
       * @method copyTo
       * @param {Object} ele contain name and id of section or menu to be copied
       * @fires actionedPopUp
       */
      copyTo(ele){
        let dim = {
          width: 550,
          height: 280
        };
        if ( this.treeMenuData.id_menu !== "" ){
          let list = this.list.filter( ele =>{
            return (ele.value !== this.treeMenuData.id_menu) && (bbn.fn.get_field(this.source.listMenu, 'value', ele.value, 'public') === false);
          }),
           cfg = {
            root: this.source.root,
            name: ele.text,
            listMenu: list,
            id: ele.id,
            menu_node: ele.menu_node !== undefined ? ele.menu_node : false,
            ctx: ele.ctx !== undefined ? ele.ctx : false
          };

          this.actionedPopUp('appui-menu-popup-copy_to', bbn._('Copy to'), cfg, dim);
        }
      },
      /*
       * Based on where is called, rename node o menu
       *
       * @method renameElement
       * @param {Booolean} menu true if rename menu, false if rename a node of tree
       * @fires actionedPopUp
       */
      renameElement(menu, current, text, id_parent, icon= false){
        if ( this.treeMenuData.id_menu !== "" ){
          let dim = {
            width: 300,
            height: 220
          },
          cfg = {
            root: this.root,
            titleMenu: text,
            idMenu: current,
            //information to understand whether we are renaming a menu or section
            menu: menu,
            id_parent: id_parent,
            icon: icon,
            public: !!this.infoMenu.public
          };
          this.actionedPopUp('appui-menu-popup-rename', bbn._('Rename'), cfg, dim);
        }
      },
      /*
       * Based on where is called,  delete menu or node of the a tree
       *
       * @method deleteElement
       *
       * @param {String} idDelete id menu or node to be Deleted
       * @param {String} text name menu or node to be Deleted
       * @param {Booolean} menu true if delete menu, false if rename a node of tree       *
       * @fires reloadTreeOfNode
       * @fires actionedPopUp
       */
       deleteElement(idDelete, text, menu){
        //checks if it has an id to make sure that you perform the delete action and that anyway this id is not that of the default menu
        if ( idDelete ){
          if ( idDelete === this.id_default ){
            appui.error( bbn._("The main menu cannot be deleted") + '!!' );
            return;
          }
          appui.confirm(
            bbn._('Secure to delete') + ': "' + text + '" ?',
            () => {
              bbn.fn.post(
                this.root + "actions/delete_element",
                {
                  id: idDelete,
                  public: !!this.infoMenu.public,
                  id_parent: menu ? this.id_parent : this.node.data.id_parent
                },
                (d) => {
                  if ( d.success ){
                    //If menu is set to true then you are deleting a menu
                    if ( menu ){
                      //the computed and on this property through which computed allows me to update the menu list in the dropdown
                      this.list = d.listMenu.length ? d.listMenu : [];
                      //returns to the initial state
                      if ( this.treeMenuData.id_menu === idDelete ){
                        setTimeout(() => {
                          this.treeMenuData.id_menu = this.list[this.list.length-1]['value'];
                          this.idxListMenu --;
                        }, 100);
                      }
                    }
                    //case delete node of a tree menu
                    else{
                      if ( this.node !== null ){
                        //case level at 0, modify items whitout reload
                        if ( this.node.level === 0 ){
                          bbn.fn.each( this.node['parent']['items'], (val, i)=>{
                            if ( idDelete === this.node['parent']['items'][i]['id'] ){
                              this.node['parent']['items'].splice(i, 1);
                              return false;
                            }
                          });
                        }
                        else {
                          appui.menu.reloadTreeOfNode();
                          let treeNode = bbn.vue.closest(this.node, "bbn-tree-node");
                          if ( treeNode.numChildren === 1 ){
                            treeNode.numChildren = 0;
                          }
                        }
                      }
                      if ( this.selected !== false ){
                        this.removeSelected();
                      }
                    }
                    appui.success( bbn._("Deleted correctly") + '!!' );
                  }
                  else{
                    appui.error( bbn._("Error, not cleared correctly") + '!!' );
                  }
                }
              );
            }
          )
        }
      },
      /*
       * Add temporaney node
       *
       * @method addTempNode
       *
       * @param {Object} node information section where to add the temporary node
       * @param {Object} cfg information (text, id_parent, id_alias, icon, numChildren)
       */
      addTempNode(node, cfg){
        if ( node ){
          node.isExpanded = true;

          if( !node.numChildren ){
            this.$nextTick(() =>{
              node.numChildren = node.numChildren + 1;
            });
          }
          setTimeout(()=>{
            this.$nextTick(() => {
              node.$refs.tree[0].isLoaded= true;
            });

              node.$refs.tree[0].items.push(cfg);
              this.formData.create = true;


              setTimeout(()=>{
                node.$refs.tree[0].$children[node.$refs.tree[0].items.length - 1].isSelected = true;
              }, 150);

          }, 600);

        }
      },
      /*
       * Add temporaney node in root menu
       *
       * @method addTempNodeInRoot
       * @param {Object} cfg information for node temporaney
       */
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
      /*
       * Open popup in form right which contains the icons to choose from
       *
       * @method openListIcons
       */
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
      /*
       * Reload tree menu appui
       *
       * @method reloadTreeMenu
       */
      reloadTreeMenu(){
        // If the three-menu has been opened then it will update the component date again.
        if ( appui.getRef('menu').hasBeenOpened ){
         //update three-menu component
          appui.getRef('menu').hasBeenOpened = false;
          this.$nextTick(() =>{
            appui.getRef('menu').$refs.tree.isLoaded = false
          });
        }
      },
      /*
       * Method that is activated at the "drag end" of the tree has the task of moving the node
       *
       * @method moveNode
       *
       * @fires reload
       * @fires removeSelected
       * @param {object} e  event jquery
       * @param {object} node node to move in the tree
       * @param {object} dest new parent of the moved node
       */
      moveNode(e, node, dest){
        if ( dest.data.id_option === null ){
          bbn.fn.post(this.root + 'actions/move', {
            id: node.data.id,
            id_parent: dest.data.id
          }, d => {
            if( d.success ){
              appui.success(bbn._('Successfully moved') + ' !!');
            }
            else{
              appui.error(bbn._('Error moved') + '!!' );
            }

            bbn.fn.log(dest, dest.getRef('tree'), node.parent, dest.$refs.tree[0], node)
            //alert();
            if ( dest.getRef('tree') === false ){
              this.$nextTick(()=>{
                dest.reload();
              });
            }
            if ( dest.$refs.tree[0] !== node.parent ){
            //refresh origin parent
            //  if ( node.items.length === 0 ){
                if ( node.parent.level === 1 ){
                  this.$refs.menus.reload();
                }
                else if ( node.parent.level > 1 ){
                  bbn.vue.closest(bbn.vue.closest(node, 'bbn-tree'), 'bbn-tree').reload();
                }
      //        }
            }

            if ( this.selected !== false ){
              this.removeSelected();
            }
          });
        }
        else{
          appui.error(bbn._('Error moved') + '!!' );
          if ( this.nodeData !== this.$refs.menus.selectedNode.data ){
            this.selected = false;
          }
          this.$refs.menus.reload();
        }
      },
      /*
       * Reload sub tree
       *
       * @method reloadTreeOfNode
       * @fires reload
       *
       */
      reloadTreeOfNode(){
        if( this.node !== null ){
          let treeOfNode = bbn.vue.closest(this.node, 'bbn-tree');
          treeOfNode.reload();
        }
      },
      /*
       * Method that is activated by the success of the form
       *
       * @method successEditionMenu
       * @fires removeSelected
       * @fires reloadTreeOfNode
       * @param {Object} d response object returned from the server
       */
      successEditionMenu(d){
        this.formData.create= false;
        if( d.success ){
          if ( this.selected !== false ){
            this.removeSelected();
          }
          if( d.create === true ){
            appui.success( bbn._("Successfully create") + '!!');
            this.emptyMenuCurrent = false;
          }
          if( d.create === false ){
            appui.error(bbn._("Error create"));
          }
          if ( d.edit === true ){
            appui.success( bbn._("Successfully edit") + '!!');
          }
        }
        else{
          appui.error(bbn._("Error!"));
        }
        //this.reloadTreeMenu();
        if ( this.node.parent.level === 0 && d.params ){
          let id = this.node['parent']['items'].length -1;
          bbn.fn.each(d.params, ( v, i ) => {
            this.node.$set(this.node['parent']['items'][id], i, v);
          });

        }
        else{
          this.reloadTreeOfNode();
        }
      },
      /*
       * Method that removes any selected node from the tree menu and closes the right form
       *
       * @method removeSelected
       *
       */
      removeSelected(){
        setTimeout(()=>{
          this.$refs.menus.selectedNode = false;
          this.selected = false;
          this.node.isSelected = false;
        }, 500);
      },
      /*
       * Method that is activated on click to select the tree menu node acquiring information and activating the form
       *
       * @method selectMenu
       * @fires reinit
       * @param {Object} node info node select
       */
      selectMenu(node){
        this.node = node;
        this.selected = false;
        this.$nextTick(() => {
          this.selected = {
            level: node.level,
            text: node.text,
            icon: node.icon,
            num: (node.data.order === undefined) ?  node.closest('bbn-tree').items.length : node.data.order,
            numChildren: node.numChildren,
            id: node.data.id,
            id_parent: node.data.id_parent,
            id_alias: node.data.id_alias,
            path: node.data.path !== undefined ? node.data.path : [],
            isExpanded: node.isExpanded,
            isActive: node.isActive,
            isMounted: node.isMounted,
            isSelected: node.isSelected,
            id_option: node.data.id_option,
            parentIsRoot: node.parent.level === 0,
            argument: node.data.argument !== undefined ? node.data.argument : '',
            menu: this.infoMenu
          };
          if ( this.$refs.form ){
            this.$refs.form.reinit();
          }
          this.elementMove = node
          let items = bbn.vue.closest(node,'bbn-tree').items,
              id =  bbn.fn.search(bbn.vue.closest(node,'bbn-tree').items, 'id', node.data.id);
          this.showOrderUp = items[id-1] !== undefined;
          this.showOrderDown = items[id+1] !== undefined;
        });
      },
      /*
       * Method that is activated selecting a pemesso from the tree of the permissions that appears in the form to the right and sets a property from the name "selected" of the object
       *
       * @method selectPermission
       *
       * @param {Object} node info node permission select
       */
      selectPermission(node){
        this.$set(this.selected, "path", node.getPath());
        this.$set(this.selected, "id_option", node.data.id);
      },
      /*
       * Method that is activated by canceling the form
       *
       * @method formCancel
       * @fires reload
       */
      formCancel(){
        //reset some properties and make a reload of the menu
        this.selected= false;
        if ( this.formData.create ){
          setTimeout(()=>{
            this.$refs.menus.reload();
          },400);
          this.formData.create= false;
        }
        if ( this.$refs.treePermission ){
          this.$refs.treePermission.$emit('pathChange');
        }
      },
      /** MAPPER OF TREE **/
      /*
       * Method that makes mappers in the menu tree
       *
       * @method mapMenu
       *
       * @param {Object} a object with info node of the server
       */
      mapMenu(a){
        return {
          data: a,
          id_menu: this.treeMenuData.id_menu,
          id: a.id,
          id_parent: a.id_parent,
          id_alias: a.id_alias,
          path: a.path || [],
          icon: a.icon,
          text: a.text,
          order: a.num,
          argument: a.argument,
          num: a.num_children || 0,
          id_option: a.id_option,
        }
      },
      /*
       * Method that returns the menu of the tree permission containing the link to it
       *
       * @method getPermissionsContext
       *
       * @fires getPath
       *
       * @param {Object} node object with info node permission
       */
      getPermissionsContext(node){
        let res = [];
        if ( node.icon === 'nf nf-fa-file' ){
          res.push({
            text: 'Go',
            icon: 'nf nf-fa-hand_o_right',
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
      /*
       * Method that makes mappers in the permissions tree
       *
       * @method mapPermissions
       *
       * @param {Object} a object with info node of the server
       */
      mapPermissions(a){
        a.text += ' &nbsp; <span class="bbn-grey">' +  "(" + a.code +  ")" + '</span>';
        return bbn.fn.extend({selectable: a.icon === 'nf nf-fa-file'}, a);
      },
      // /**
      //  * FOR MENU SPLITER LEFT
      //  */
      //
      // ctrlStartDrag(){
      //   bbn.fn.log("STArt DRAG", this, arguments);
      //   /* let node = arguments[0],
      //    event = arguments[1];
      //    if( (node.items.length) && (node.numChildren > 0) || (node.icon === 'nf nf-fa-key') ){
      //    event.preventDefault();
      //    }*/
      // },
      // ctrlEndDrag(){
      //   bbn.fn.log("END DRAG",  arguments[0]);
      //   let node = arguments[0],
      //       event = arguments[1];
      //   /*
      //    if( (!node.items.length) && (node.numChildren === 0) && (node.icon !== 'nf nf-fa-key') ){
      //    event.preventDefault();
      //    }
      //    */
      // },
      // /**
      //  *  FOR MENUS SPLITER RIGHT
      //  */
      // ctrlStartDragMenus(node){
      //   bbn.fn.warning("START");
      //   bbn.fn.log(node, node.data, node.data.id_parent);
      //   //acquire the id of the node we want to move
      //   //this.idStartMove = node.data.id;
      // },
      //activates when the node to be moved is released, it performs checks and, if necessary, performs the displacement action
      ctrlEndDragMenus(node, ev, destination){
        //The node shifts can do so all except the default menu that reside in the right splitter.

        if ( this.treeMenuData.id_menu !== this.id_default ){
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
                  appui.success(bbn._('It has been moved correctly'));
                }
                else{
                  appui.error(bbn._("It has not been moved correctly"));
                }
              }
            );
          }
        }
      }
    },
    watch:{
      /*
       * @watch treeMenuData.id_menu
       * @fires reload
       */
      'treeMenuData.id_menu'(val, old){
        for ( let i in this.list ){
          if ( this.list[i]['id'] === val ){
            this.idxListMenu = parseInt(i);
            this.emptyMenuCurrent = this.list[i]['num_children'] == 0;
          }
        }
        //keep track of the previous root
        this.oldRootMenu = old;
        this.selected = false;
        if ( old && (val !== old) ){
          this.$refs.menus.reload();
        }
      },
    },
    /**
     * @event craeted
     * instantiate the property menu of the appui object
     */
    created(){
      appui.menu = this;
    }
  }
})();
