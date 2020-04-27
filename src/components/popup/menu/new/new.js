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
        root: appui.plugins['appui-menu'] + '/',
        menu: appui.getRegistered('appui-menu'),
        formSource: {
          title: ''
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
          appui.success(bbn._("Created"));
        }
        else{
          appui.error();
        }
      }
    }
  }
})();
