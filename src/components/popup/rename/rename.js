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
        newTitle: '',
      }
    },
    methods: {
      beforeSubmit(source){
        if ( !source.newTitle.length ){
          alert('ALT!! Before submit write name section');
        }
        return !!source.newTitle.length;
      },
      onSuccess(d){
        if ( d.success ){
          if ( this.infoData.menu ){
            appui.menu.list = d.listMenu;
            appui.success(bbn._("Successfully rename menu!"));
            appui.menu.reloadTreeMenu();
          }
          else{
            if ( appui.menu.node.level === 0 ){
              for ( let i in appui.menu.node['parent']['items'] ){
                if ( this.infoData.id === appui.menu.node['parent']['items'][i]['id'] ){
                  appui.menu.node.$set(appui.menu.node['parent']['items'][i], 'text', this.newTitle);
                }
              }
            }
            else{
              appui.menu.reloadTreeOfNode();
              appui.success(bbn._("Successfully rename!"));
            }
          }
        }
        else{
          appui.error(bbn._("Error rename!"));
        }

        bbn.vue.closest(this, ".bbn-popup").close();
      },
    },
    computed: {
      infoData(){
        let infoForm = {
          id: this.source.idMenu,
          menu: this.source.menu,
        };
        if ( this.source.id_parent ){
          $.extend(infoForm, {id_parent: this.source.id_parent});
        }
        else{
          $.extend(infoForm, {icon: this.source.icon});
        }
        return infoForm
      }
    }
  }
})();
