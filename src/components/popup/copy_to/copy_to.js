/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 25/10/18
 * Time: 18.20
 */
(()=>{
  return{
    props: ['source'],
    data(){
      return{
        info:{
          id_menu_to: null,
          text: this.source.name,
          icon: 'nf nf-fa-cog'
        }
      }
    },
    computed:{
      menuInfo(){
        let obj = {
          public_menu_to: !!bbn.fn.get_field(this.source.listMenu, 'value', this.infoCopy.id_menu_to, 'public')
        }
        return obj;
      },
      infoCopy(){
        if ( this.source.ctx ){
          return {
            id: this.source.id,
            menu_node: this.source.menu_node,
            id_menu_to: this.info.id_menu_to,
            text: this.info.text,
            icon: this.info.icon
          };
        }
        return {
          id: this.source.id,
          id_menu_to: this.info.id_menu_to,
          text: this.info.text,
          icon: this.info.icon
        };
      }
    },
    methods:{
      onSuccess(d){
        if ( d.success ){
          appui.success(bbn._("Successfully copied menu!"));
        }
        else{
          appui.error(bbn._("Error copy!"));
        }
      },
      listIcon(){
        appui.$refs.tabnav.activeTab.getPopup().open({
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
