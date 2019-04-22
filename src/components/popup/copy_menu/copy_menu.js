/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 12/10/17
 * Time: 14.57
 */

(() => {
  return {
    data(){
      return {
        newTitleMenu: ''
      }
    },
    methods: {
      onSuccess(d){
        if ( d.success ){
          if ( (d.listMenu !== undefined) && (d.listMenu.length) ){
            appui.menu.list = d.listMenu;
          }
          appui.menu.reloadTreeMenu();
          appui.success(bbn._("Successfully copied menu!"));
        }
        else{
          if ( d.errorMessage ){
            appui.error(bbn._(" You cannot copy the menu with the same name"));
          }
          else{
            appui.error(bbn._("Error copy!"));
          }
        }

        bbn.vue.closest(this, ".bbn-popup").close();
      }
    },
    computed: {
      formCopy(){
        return {
          nameCopyMenu: this.source.titleMenu,
          id_parent: this.source.id_parent,
          id_copy: this.source.id
        }
      }
    }
  }
})();
