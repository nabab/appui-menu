/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 12/10/17
 * Time: 14.57
 */

Vue.component('appui-menu-popup-copy_menu', {
  name:'appui-menu-popup-copy_menu',
  template: '#bbn-tpl-component-appui-menu-popup-copy_menu',
  props: ['source'],
  data(){
    return {
     newTitleMenu:''
    }
  },
  methods:{
    beforeSubmit(){

    },
    onSuccess(d){
      if ( d.success ){
        //let i = d.listMenu.length -1;

        appui.menu.list = d.listMenu;
        setTimeout(() => {
          //appui.menu.currentMenu = d.listMenu[i]['id'];
          //appui.menu.clickNext();
        }, 500);
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
    },
    /*onFailure(){

      bbn.vue.closest(this, ".bbn-popup").close();
    }*/
  },
  computed:{
    formCopy(){
      return {
        nameCopyMenu: this.source.titleMenu,
        id_parent: this.source.id_parent,
        id_copy: this.source.id
      }
    }
  }
});
