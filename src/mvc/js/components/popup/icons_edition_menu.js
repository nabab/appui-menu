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
      dataIcons:{
        faicons: [],
        material: [],
        mficons: []
      },
      totIcons: [],
      search:"",
      totNumberIcon: bbn._('Count icons ...')
    }
  },
  methods: {
    selectIcon(icon){
      appui.menu.selected.icon = icon;
      this.search = "";
      bbn.vue.closest(this, ".bbn-popup").close();
    }
  },
  created(){
    bbn.fn.post(this.root + "actions/icons", {
      index: true
    }, d =>{
      if ( d.icons ){
        this.dataIcons.faicons = d.icons.faicons;
        this.dataIcons.material = d.icons.material;
        this.dataIcons.mficons = d.icons.mficons;
        this.totIcons = d.list
        if ( d.total ){
          this.totNumberIcon = bbn._('Search in') + ' ' + d.total.toString() + ' ' + bbn._('icons');
        }
      }
    });
  },
  computed:{
    icons(){
      if ( this.search.length ){
        let  arr = [];
        for ( let ele of this.totIcons ){
          if( ele.search(this.search.toLowerCase()) > - 1 ){
            arr.push(ele);
          }
        }
        return arr
      }
      else{
        return this.totIcons
      }
    }
  }
});