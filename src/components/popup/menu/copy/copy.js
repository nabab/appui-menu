/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 12/10/17
 * Time: 14.57
 */

(() => {
  return {
    data(){
      let menu = appui.getRegistered('appui-menu');
      return {
        root: appui.plugins['appui-menu'] + '/',
        menu: menu,
        formSource: {
          title: menu.currentMenu.name,
          id: menu.currentID
        }
      }
    },
    methods: {
      onSuccess(d){
        if ( d.success ){
          if ( (d.menus !== undefined) ){
            this.menu.$set(this.menu.source, 'menus', d.menus);
          }
          this.$nextTick(() => {
            this.menu.currentID = d.id;
          });
          appui.success(bbn._("Copied"));
        }
        else {
          appui.error();
        }
      }
    }
  }
})();
