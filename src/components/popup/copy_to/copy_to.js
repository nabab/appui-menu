/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 25/10/18
 * Time: 18.20
 */
(() => {
  return {
    data(){
      let menu = appui.getRegistered('appui-menu');
      return {
        root: appui.plugins['appui-menu'] + '/',
        menu: menu,
        menus: menu.source.menus.filter(m => {
          return (m.id !== menu.currentMenu.id) && !m.public;
        }),
        formSource: bbn.fn.extend(true, {to: ''}, this.source)
      }
    },
    methods:{
      onSuccess(d){
        if ( d.success ){
          appui.success(bbn._("Copied"));
        }
        else{
          appui.error();
        }
      },
      listIcon(){
        this.getPopup().open({
          width: '80%',
          height: '80%',
          title: bbn._('Select icons'),
          component: 'appui-core-popup-iconpicker',
          source: {
            obj: this.info,
            field: 'icon'
          }
        });
      }
    }
  }
})();
