(() => {
  return {
    created() {
      appui.register('appui-menu-fisheye', this);
    },
    data() {
      return {
        shortcuts: this.source.shortcuts || [],
        isMobile: bbn.fn.isMobile(),
        leftShortcuts: [{
          url: data.plugins['appui-dashboard'] + '/home',
          text: bbn._("Dashboard"),
          icon: 'nf nf-fa-dashboard'
        }],
        rightShortcuts: [{
          url: data.plugins['appui-usergroup'] + '/main',
          text: bbn._("My profile"),
          icon: 'nf nf-fa-user'
        }, {
          action(){
            appui.popup().load({
              url: data.plugins['appui-core'] + '/help',
              width: '90%',
              height: '90%',
              scrollable: false
            });
          },
          text: bbn._("Help"),
          icon: 'nf nf-mdi-help_circle_outline'
        }, {
          action(){
            bbn.fn.toggleFullScreen();
          },
          text: bbn._("Full screen"),
          icon: 'nf nf-fa-arrows_alt'
        }, {
          text: bbn._("Log out"),
          icon: 'nf nf-fa-sign_out',
          action(){
            bbn.fn.post(appui.plugins['appui-core'] + '/logout', d => {
              if (d.success && d.data && d.data.url) {
                document.location.href = d.data.url;
              }
              else {
                appui.error();
              }
            });
          }
        }],

      };
    },
    methods: {
      addShortcut(data){
        if (appui.plugins['appui-menu']) {
          let ok = !!(data.id || data.url);
          if (data.id) {
            let idx = bbn.fn.search(this.shortcuts, {id: data.id});
            if ( idx > -1 ){
              ok = false;
            }
          }

          if (ok) {
            bbn.fn.post(appui.plugins['appui-menu'] + '/shortcuts/insert', data, d => {
              if ( d.success ){
                this.shortcuts.push(data);
              }
            });
          }
        }
        else if ( appui.plugins['appui-menu'] && data.url ){
          bbn.fn.post(appui.plugins['appui-menu'] + '/shortcuts/insert', data, d => {
            if ( d.success ){
              this.shortcuts.push(data);
            }
          });
        }
      },
      removeShortcut(data){
        if ( appui.plugins['appui-menu'] && data.id ){
          bbn.fn.post(appui.plugins['appui-menu'] + '/shortcuts/delete', data, d => {
            if ( d.success ){
              let idx = bbn.fn.search(this.shortcuts, {id: data.id});
              if ( idx > -1 ){
                this.shortcuts.splice(idx, 1);
              }
              appui.success();
            }
            else {
              appui.error(bbn._("Error while deleting the shortcut"));
            }
          });
        }
      },
    }
  };
})();

