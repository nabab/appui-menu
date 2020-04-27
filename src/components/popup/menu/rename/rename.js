/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 27/10/17
 * Time: 13.32
 */

(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-menu'] + '/',
        menu: appui.getRegistered('appui-menu')
      }
    },
    methods: {
      onSuccess(d){
        if ( d.success ){
          this.menu.currentMenu.name = this.formSource.text;
          appui.success(bbn._('Renamed'));
        }
        else{
          appui.error();
        }
      }
    }
  }
})();
