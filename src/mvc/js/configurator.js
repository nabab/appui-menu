(() => {
  return {
    data(){
      return {
        selected: false,
        currentID: this.source.menus && this.source.menus.length ? this.source.menus[0].id : '',
        root: appui.plugins['appui-menu'] + '/',
        defaultIcon: 'nf nf-fa-cog',
        optionsPath: appui.plugins['appui-option'] + '/',
        isCurrentIdChanging: false
      }
    },
    computed: {
      disabledAction(){
        return !this.currentMenu || (!this.currentMenu.public && ((!appui.app.user.isDev || !appui.app.user.isAdmin)));
      },
      currentMenu(){
        if ( this.source.menus && this.currentID ){
          return bbn.fn.getRow(this.source.menus, {id: this.currentID});
        }
        return false;
      },
      currentIdx(){
        if ( this.source.menus && this.currentID){
          return bbn.fn.search(this.source.menus, {id: this.currentID});
        }
        return -1;
      },
      isCurrentDefault(){
        return this.currentID && this.source.defaultMenu && (this.currentID === this.source.defaultMenu);
      },
      /**
       * Checks if there are more menus if it returns true the arrows will appear to scroll through the list
       * @computed showArrows
       * @return {Boolean}
       */
      showArrows(){
        return this.source.menus && (this.source.menus.length > 1);
      },
      formStyle(){
        let r = {
          'grid-template-rows': 'max-content max-content'
        };
        if ( this.selected ){
          if ( this.selected.data.id ){
            r['grid-template-rows'] += ' max-content';
          }
          r['grid-template-rows'] += ' auto';
          if ( this.selected.data.id_option ){
            r['grid-template-rows'] += ' max-content';
          }
        }
        return r;
      }
    },
    methods: {
      _fixOrder(deep, node){
        this.post(this.root + 'actions/fixorder', {
          id_menu: this.currentID,
          id_parent: node ? node.data.id : null,
          deep: !!deep
        }, d => {
          if ( d.success ){
            appui.success(d.fixed + ' ' + bbn._('items fixed'));
            if ( d.fixed ){
              if ( node ){
                let tree = node.getRef('tree');
                if ( tree ){
                  tree.reload();
                }
              }
              else {
                this.getRef('menuTree').reload();
              }
              this.updateTreeMenu();
            }
          }
          else {
            appui.error();
          }
        });
      },
      makeDefault(){
        alert("default")
      },
      fixOrder(node){
        if (
          (bbn.fn.isVue(node) && !!node.numChildren) ||
          (!bbn.fn.isVue(node) && this.getRef('menuTree').currentData.length)
        ){
          this.getPopup().open({
            title: bbn._('Warning'),
            content: '<div class="bbn-lpadded bbn-medium">' + bbn._('Do you want to order in depth') + '?</div>',
            resizable: false,
            maximizable: false,
            closable: false,
            scrollable: true,
            buttons: [{
              text: bbn._('Yes'),
              class: 'bbn-bg-green bbn-white',
              icon: 'nf nf-fa-check_circle',
              action: ($ev, btn) => {
                btn.closest('bbn-floater').close();
                setTimeout(() => {
                  this._fixOrder(true, bbn.fn.isVue(node) ? node : false);
                }, 0)
              }
            }, {
              text: bbn._('No'),
              class: 'bbn-bg-red bbn-white',
              icon: 'nf nf-fa-times_circle',
              action: ($ev, btn) => {
                btn.closest('bbn-floater').close();
                setTimeout(() => {
                  this._fixOrder(false, bbn.fn.isVue(node) ? node : false);
                }, 0)
              }
            }, {
              text: bbn._('Cancel'),
              icon: 'nf nf-fa-close',
              action($ev, btn){
                btn.closest('bbn-floater').close();
              }
            }]
          })
        }
      },
      updateTreeMenu(){
        let treeMenu = appui.find('bbn-treemenu');
        if (treeMenu && (treeMenu.currentMenu === this.currentID)) {
          treeMenu.reset();
        }
      },
      /**
       * Moves the selected element from the given old position to the given new one.
       * @method order
       * @param {Number} olNum
       * @param {Number} newNum
       * @param {Event} ev
       */
      order(oldNum, newNum, node, ev){
        if ( ev ){
          ev.preventDefault();
        }
        if ( newNum && node.data.id && this.currentID ){
          this.post(this.root + 'actions/item/order', {
            id: node.data.id,
            id_menu: this.currentID,
            num: newNum
          }, d => {
            if ( d.success ){
              this.updateTreeMenu();
              node.reorder(oldNum, newNum, true);
              appui.success('Ordered');
            }
            else {
              appui.error();
            }
          });
        }
      },
      /**
       * Moves the selected element up one position.
       * @method moveU
       * @fires order
       */
      moveUp(){
        if ( this.selected && (this.selected.source.num > 1) ){
          this.order(this.selected.source.num, this.selected.source.num - 1, this.selected);
        }
      },
      /**
       * Moves the selected element down one position
       * @method moveDown
       * @fires order
       */
      moveDown(){
        if ( this.selected && (this.selected.source.num < this.selected.parent.currentData.length) ){
          this.order(this.selected.source.num, this.selected.source.num + 1, this.selected);
        }
      },
      /** CONTEXTMENU **/
      /**
       * Returns an array for the context menu of the menu tree (right splitter)
       *
       * @method contextMenu
       * @fires deleteItem
       * @fires addTempNode
       * @fires copyTo
       */
      contextMenu(node){
        let ctx = [];
        if ( !this.disabledAction ){
          ctx =  [{
            icon: 'nf nf-fa-trash',
            text: bbn._('Delete'),
            action: n => {
              this.deleteItem(n);
            }
          }];
          //case context in section menu
          if ( node.data.id_option === null ){
            // if node is sectiom transform to link
            if ( !node.numChildren ){
              ctx.push({
                icon: 'nf nf-custom-elm',
                text: bbn._('Transform to link'),
                action: n => {
                  this.selectItem(n);
                  this.$nextTick(() => {
                    this.selected.$set(this.selected.data ,'id_option', '')
                  });
                }
              });
            }
            else {
              ctx.push({
                icon: 'nf nf-mdi-sort_alphabetical',
                text: bbn._('Fix order'),
                action: n => {
                  this.fixOrder(n);
                }
              });
            }
            //adds the possibility of create sub-section
            ctx.unshift({
              icon: 'nf nf-fa-level_down',
              text: bbn._('New sub-section'),
              action: n => {
                this.createSection(n);
              }
            });
            //adds the possibility of create a link
            ctx.unshift({
              icon: 'nf nf-fa-link',
              text: bbn._('New link'),
              action: n => {
                if ( bbn.fn.isNull(n.data.id_option) ){
                  this.createLink(n);
                }
              }
            });
          }
          else{
            //convert the link menu in section menu
            ctx.push({
              icon: 'nf nf-custom-elm',
              text: bbn._('Transform to section'),
              action: n => {
                this.selectItem(n);
                this.$nextTick(()=>{
                  this.selected.$set(this.selected.data, 'id_option', null);
                });
              }
            });
          }
        }
        //adds the possibility of copy the section to another menu
        ctx.push({
          icon: 'nf nf-fa-copy',
          text: bbn._('Copy to'),
          action: n => {
            this.copyTo({
              id: n.data.id,
              text: n.data.text,
              icon: n.data.icon,
              id_user_option: this.currentMenu.id
            });
          }
        });
        return ctx
      },
      /**METHODS FOR BUTTONS ACTIONS IN THE TOP SPLITER LEFT **/

      /**
       * Opens the form to create a menu;
       * @method createMenu
       * @fires getPopup
       */
      createMenu(){
        this.getPopup().open({
          width: 300,
          title: bbn._('New menu'),
          component: 'appui-menu-popup-menu-new'
        });
      },
      /**
       * Copy a menu, this is operated by the top-bar button "copy menu"
       *
       * @method copyMenu
       */
      copyMenu(){
        if ( this.currentID ){
          this.getPopup().open({
            width: 300,
            title: bbn._('Copy menu'),
            component: 'appui-menu-popup-menu-copy',
            source: {
              id: this.currentID
            }
          });
        }
      },
      /**
       * Temporarily adds a new section in root this is operated by the top-bar button "Copy menu"
       *
       * @method createSection
       *
       * @fires addTempNode
       */
      createSection(node){
       this.addTempNode({
         text: bbn._('Untitled Section'),
         id_parent: bbn.fn.isVue(node) && node.data ? node.data.id : null,
         id_option: null,
         id_user_option: this.currentMenu.id,
         icon: this.defaultIcon,
         num: this.getNextNum(bbn.fn.isVue(node) ? node.parent : false),
         numChildren: 0
       }, bbn.fn.isVue(node) ? node : false);

      },
      /**
       * Delete current menu this is operated by the top-bar button "Delete menu"
       *
       * @method deleteMenu
       * @fires deleteElement
       */
      deleteMenu(){
        bbn.fn.log("currentID ??");
        if ( this.currentID ){
          bbn.fn.log("currentID OK");
          if ( this.isCurrentDefault ){
            appui.error(bbn._("The main menu cannot be deleted"));
            return;
          }
          this.confirm(
            bbn._('Are you sure you want to delete the menu') + ': "' + text + '?',
            () => {
              this.post(this.root + "actions/menu/delete", {id: this.currentID}, d => {
                  if ( d.success ){
                    this.currentID = '';
                    this.$set(this.source, 'menus', d.menus || []);
                    appui.success(bbn._("Deleted"));
                  }
                  else{
                    appui.error();
                  }
                }
              );
            }
          )
        }
      },
      /**
       * Rename current menu this is operated by the top-bar button "Rename menu"
       *
       * @method renameMenu
       */
      renameMenu(){
        this.getPopup().open({
          title: bbn._('Rename'),
          component: 'appui-menu-popup-menu-rename',
          source: {
            id: this.currentMenu.id,
            text: this.currentMenu.name
          }
        });
      },
      getNextNum(tree){
        let num = 0;
        if ( !tree ){
          tree = this.getRef('menuTree');
        }
        if ( tree ){
          bbn.fn.each(tree.currentData, d => {
            let tmp = d.data && d.data.num ? d.data.num : d.num;
            if ( tmp > num ){
              num = tmp;
            }
          })
        }
        return num + 1;
      },
      /**
       * Create a new link in root of  current menu  set id_alias at 1 this is operated by the top-bar button "Create link"
       *
       * @method createLink
       * @fires addTempNode
       */
      createLink(node){
        this.addTempNode({
          text: bbn._('Untitled Link'),
          id_parent: bbn.fn.isVue(node) && node.data ? node.data.id : null,
          id_option: '',
          id_user_option: this.currentMenu.id,
          icon: this.defaultIcon,
          num: this.getNextNum(bbn.fn.isVue(node) ? node.parent : false),
          numChildren: 0
        }, bbn.fn.isVue(node) ? node : false);
      },
      /**
       * Copy the current menu and assign it to the root of another selected menu this is operated by the top-bar button "Copy menu to"
       *
       * @method copyMenuTo
       * @fires copyto
       */
      copyMenuTo(){
        this.copyTo({
          text: this.currentMenu.name,
          id_user_option: this.currentMenu.id,
          icon: this.defaultIcon
        });
      },
      /**
       * Allows backward scrolling of the menu list one by one  this is operated by the top-bar button "back menu"
       *
       * @method prevMenu
       */
      prevMenu(){
        if (
          this.source.menus &&
          this.source.menus.length &&
          (this.currentIdx > 0) &&
          this.source.menus[this.currentIdx-1]
        ){
          this.selected = false;
          this.currentID = this.source.menus[this.currentIdx-1].id;
        }
      },
      /**
       * Allows forward scrolling of the menu list, one by one  this is operated by the top-bar button "Next menu"
       *
       * @method nextMenu
       */
      nextMenu(){
        if (
          this.source.menus &&
          this.source.menus.length &&
          (this.currentIdx < (this.source.menus.length - 1)) &&
          this.source.menus[this.currentIdx+1]
        ){
          this.selected = false;
          this.currentID = this.source.menus[this.currentIdx+1].id;
        }
      },
      /**
       * Based on where is called, copy section or memu and  put in another root menu
       *
       * @method copyTo
       * @param {Object} src
       */
      copyTo(src){
        this.getPopup().open({
          title: bbn._('Copy to'),
          width: 350,
          component: 'appui-menu-popup-copy_to',
          source: src
        });
      },
      /**
       * Based on where is called,  delete menu or node of the a tree
       *
       * @method deleteItem
       * @param {Vue} node
       */
       deleteItem(node){
        if ( node && node.data && node.data.id ){
          this.confirm(bbn._('Are you sure you want to delete this item?'), () => {
            this.post(this.root + "actions/item/delete", {id: node.data.id}, d => {
              if ( d.success ){
                if ( this.selected === node ){
                  this.selected = false;
                }
                if ( !node.parent.isRoot && node.parent.node && (node.parent.node.numChildren > 0) ){
                  node.parent.node.numChildren--;
                }
                this.$nextTick(() => {
                  node.parent.reload();
                })
                this.updateTreeMenu();
                appui.success(bbn._("Deleted"));
              }
              else{
                appui.error();
              }
            });
          });
        }
      },
      /**
       * Add temporaney node
       *
       * @method addTempNode
       * @param {Object} node information section where to add the temporary node
       * @param {Object} cfg information (text, id_parent, id_alias, icon, numChildren)
       */
      addTempNode(cfg, node){
        let tree = this.getRef('menuTree');
        if ( tree ){
          if ( node ){
            if ( !node.numChildren ){
              node.numChildren = 1;
            }
            this.$nextTick(() => {
              tree = node.getRef('tree');
              if ( node.isExpanded ){
                cfg = tree.addNode(cfg);
                this.$nextTick(() =>{
                  let n = bbn.fn.getRow(tree.nodes, {idx: cfg.index});
                  n.$set(n, 'isSelected', true);
                });
              }
              else {
                tree.$once('dataloaded', () => {
                  cfg = tree.addNode(cfg);
                  this.$nextTick(() =>{
                    let n = bbn.fn.getRow(tree.nodes, {idx: cfg.index});
                    n.$set(n, 'isSelected', true);
                  });
                });
                node.isExpanded = true;
              }
            })
          }
          else {
            cfg = tree.addNode(cfg);
            if ( cfg ){
              this.currentMenu.hasItems = true;
              this.$nextTick(() =>{
                let n = bbn.fn.getRow(tree.nodes, {idx: cfg.index});
                n.$set(n, 'isSelected', true);
              });
            }
          }
        }
      },
      /**
       * Open popup in form right which contains the icons to choose from
       *
       * @method openListIcons
       */
      openListIcons(){
        appui.getRef('router').activeContainer.getPopup().open({
          width: '80%',
          height: '80%',
          title: bbn._('Select icons'),
          component: 'appui-core-popup-iconpicker',
          source: {
            obj: this.selected,
            field: 'icon'
          }
        });
      },
      /**
       * Method that is activated at the "drag end" of the tree has the task of moving the node
       *
       * @method moveNode
       *
       * @fires reload
       * @param {object} e  event jquery
       * @param {object} node node to move in the tree
       * @param {object} dest new parent of the moved node
       */
      moveNode(node, dest, ev){
        ev.preventDefault();
        if ( dest.data.id_option === null ){
          this.post(this.root + 'actions/item/move', {
            id: node.data.id,
            id_parent: dest.data.id
          }, d => {
            if ( d.success ){
              this.selected = false;
              this.getRef('menuTree').move(node, dest, true);
              this.updateTreeMenu();
              appui.success(bbn._('Moved'));
            }
            else {
              appui.error();
            }
          });
        }
      },
      /**
       * Method that is activated by the success of the form
       *
       * @method formSuccess
       * @param {Object} d
       */
      formSuccess(d){
        if ( d.success ){
          appui.success(this.selected.data.id ? bbn._('Edited') : bbn._('Inserted'));
          this.selected.parent.reload();
          this.selected = false;
          this.updateTreeMenu();
        }
        else {
          appui.error();
        }
      },
      /**
       * Method that is activated on click to select the tree menu node acquiring information and activating the form
       *
       * @method selectItem
       * @fires reinit
       * @param {Object} node info node select
       */
      selectItem(node){
        this.selected = node;
        //this.selected.parentIsRoot =  node.parent.level === 0;
        this.$nextTick(() => {
          let form = this.getRef('form');
          if ( form ){
            form.reinit();
          }
        });
      },
      permissionsTreeOpenPath(){
        let tree = this.getRef('permissionsTree');
        if ( tree ){
          tree.openPath();
        }
      },
      /**
       * Method that is activated selecting a pemesso from the tree of the permissions that appears in the form to the right and sets a property from the name "selected" of the object
       *
       * @method selectPermission
       * @param {Object} node
       */
      selectPermission(node){
        bbn.fn.log("PERMI??", node);
        this.$set(this.selected.data, "path", node.getPath());
        this.$set(this.selected.data, "id_option", node.data.id);
      },
      /**
       * Method that is activated by canceling the form
       *
       * @method formCancel
       * @fires reload
       */
      formCancel(){
        this.selected = false;
      },
      /**
       * Method that makes mappers in the menu tree
       *
       * @method mapMenu
       */
      mapMenu(a){
        a.argument = a.argument || '';
        return a;
      },
      /**
       * Method that returns the menu of the tree permission containing the link to it
       *
       * @method getPermissionsContext
       *
       * @fires getPath
       *
       * @param {Object} node object with info node permission
       */
      getPermissionsContext(node){
        bbn.fn.log('aaaa',node)
        let res = [];
        if ( node.data.selectable ){
          res.push({
            text: 'Go',
            icon: 'nf nf-fa-hand_o_right',
            action: (node) => {
              this.post(
                appui.plugins['appui-option'] + '/permissions',
                {
                  id: node.data.id,
                  full: 1
                },
                (d) =>{
                  bbn.fn.link(d.data.path);
                }
              );
            }
          });
        }
        return res;
      },
      /**
       * Method that makes mappers in the permissions tree
       *
       * @method mapPermissions
       *
       * @param {Object} a object with info node of the server
       */
      mapPermissions(a){
        a.text += ' &nbsp; <span class="bbn-grey">' +  "(" + a.code +  ")" + '</span>';
        a.selectable = a.icon === 'nf nf-fa-file';
        return a;
      },
      async exportMenu(){
        let cp = this;
        let res = [];
        let tree = this.getRef('menuTree');
        let p = async function(o, node) {
          let tree = node.find('bbn-tree');
          if (!node.isExpanded) {
            await tree.updateData();
            node.parent.currentData[node.source.index].expanded = true;
          }
          await new Promise((resolve, reject) => setTimeout(resolve, 500));
          o.items = await fn(tree, []);
          return new Promise((resolve, reject) => {
            resolve(o);
          })
        };

        let fn = async function(tree, r) {
          let tmp;
          for (let i = 0; i < tree.currentData.length; i++) {
            let a = tree.currentData[i];
            let node = tree.getNodeByIdx(i);
            let o = {
              text: node.data.text,
              num: i+1
            };
            if (node.data.icon) {
              o.icon = node.data.icon;
            }
            if (node.data.link) {
              o.link = node.data.link;
            }
            if (a.numChildren) {
              tmp = await p(o, node);
            }
            else {
              tmp = o;
            }
            r.push(tmp);
          }
          return new Promise((resolve, reject) => {
            resolve(r);
          });
        };
        
        let result = null;
        if (tree) {
          let result = await fn(tree, res);
          cp.getPopup({
            title: "Export",
            content: '<div class="bbn-padded"><pre>' + JSON.stringify(result, null, 2) + '</pre></div>',
            width: '100%',
            height: '100%'
          });
        }
        return new Promise((resolve, reject) => {
          resolve(result);
        });
      }
    },
    /**
     * @event created
     * instantiate the property menu of the appui object
     */
    created(){
      appui.register('appui-menu', this);
    },
    beforeDestroy() {
      appui.unregister('appui-menu');
    },
    watch:{
      /**
       * @watch currentID
       */
      currentID(val, old){
        if (this._currentIdChanger) {
          clearTimeout(this._currentIdChanger);
        }
        this.isCurrentIdChanging = true;
        this._currentIdChanger = setTimeout(() => {
          this.isCurrentIdChanging = false;
        }, 250);
        this.selected = false;
      }
    }
  }
})();