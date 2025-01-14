// Javascript Document

(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-menu'] + '/',
        cf: null,
        data: {
          title: '',
          icon: '',
          location: '',
          link: '',
          argument: ''
        }
      }
    },
    methods: {
      success(){
        bbn.fn.log("SUCCESS")
      },
      // Taken from permissions
      openListIcons(){
        this.closest('bbn-container').getPopup({
          width: '80%',
          height: '80%',
          label: bbn._('Select icons'),
          component: 'appui-core-popup-iconpicker',
          source: {
            obj: this.selected,
            field: 'icon'
          }
        });
      },
    }
  }
})();