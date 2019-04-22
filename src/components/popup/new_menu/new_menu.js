/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 12/10/17
 * Time: 14.58
 */

(() => {
  return {
    data(){
      return {
        titleMenu: '',
        id_parent: this.source.id_parent,
      }
    },
    methods: {
      beforeSubmit(source, originalSource){
        if ( !source.titleMenu.length ){
          alert(bbn._("ALT!!!! Enter a title to the new menu"));
          return !!source.titleMenu.length;
        }
      },
      onSuccess(d){
        //update the menu list
        if ( d.success ){
          appui.menu.list = d.listMenu;
          setTimeout(() => {
            appui.menu.treeMenuData.id_menu = d.idNew;
          }, 100);
          appui.menu.reloadTreeMenu();
          appui.success(bbn._("Successfully created new menu!"));
        }
        else{
          appui.error(bbn._("Error create menu!"));
        }

        bbn.vue.closest(this, ".bbn-popup").close();
      },
      onFailure(){
        /* appui.error(bbn._("Error create menu!"));
         bbn.vue.closest(this, ".bbn-popup").close();*/
      }
    },
    computed: {},
  }
})();
