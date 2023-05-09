(() => {
  return {
    data() {
      return {
        isMobile: bbn.fn.isMobile()
      };
    },
    methods: {
      toggle() {
        const menu = appui.getRegistered('menu');
        bbn.fn.log(menu);
        if (menu) {
          menu.toggle();
        }
      }
    }
  };
})();

