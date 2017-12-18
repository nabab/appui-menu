/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 10/11/17
 * Time: 11.35
 */

Vue.component('appui-menu-popup-icons_edition_menu', {
  name: 'appui-menu-popup-icons_edition_menu',
  template: '#bbn-tpl-component-appui-menu-popup-icons_edition_menu',
  props: ['source'],
  data(){
    return {
      root:this.source.root,
      icons:{
        faicons: [],
        material: [],
        mficons: []
      },
      totIcons: []
    }
  },
  methods: {
    selectIcon(icon){
      appui.menu.selected.icon = icon;
      bbn.vue.closest(this, ".bbn-popup").close();
    }
  },
  created(){
    bbn.fn.post(this.root + "actions/icons", {
      index: true
    }, (d) =>{
      if ( d ){
        if ( d.faicons.length ){
          for ( let nameFaicons of d.faicons ){
            this.icons.faicons.push("fa fa-" + nameFaicons);
            this.totIcons.push("fa fa-" + nameFaicons);
          }
        }
        if ( d.material.length ){
          $.each(d.material, (i, v) =>{
            this.totIcons.push("zmdi zmdi-" + v);
            this.icons.material.push("zmdi zmdi-" + v)
          });
        }
        if ( d.mficons.length ){
          let ele = [];
          $.each(d.mficons, (i, v) =>{
            $.each(v.icons, (j, value) =>{
              this.totIcons.push("icon-" + value);
              this.icons.mficons.push("icon-" + value);
            });
          });
        }
      }
    });
  }
});