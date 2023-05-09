(() => {
  return {
    created() {
      appui.register('menu', this);
    },
    data() {
      return {
        isMobile: bbn.fn.isMobileDevice(),
        isTablet: bbn.fn.isTabletDevice(),
        menuMounted: false,
        root: appui.plugins['appui-menu'] + '/'
      };
    },
    methods: {
      addShortcut() {
        const fisheye = appui.getRegistered('appui-menu-fisheye');
        if (fisheye) {
          return fisheye.addShortcut(...arguments);
        }
      },
      focusSearchMenu(){
        const menu = this.getRef('menu');
        if (menu) {
          menu.focusSearch();
        }
      },
      toggle() {
        const slider = this.getRef('slider');
        if (slider) {
          bbn.fn.log(slider);
          slider.toggle();
        }
      }
    }
  };
})();

