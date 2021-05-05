// Javascript Document

(() => {
  return {
    data(){
      let data = {};
      if (bbn.fn.isArray(this.source)) {
        bbn.fn.each(this.source, a => {
          if (a.name) {
            if (data[a.name] === undefined) {
              if (a.default) {
                data[a.name] = bbn.fn.isFunction(a.default) ? a.default() : a.default
              }
              else {
                data[a.name] = a.nullable ? null : ''
              }
            }
          }
        })
      }

      return {
        items: [
          {
            name: "title",
            title: bbn._("Title")
          }, {
            name: "icon",
            title: bbn._("Icon"),
            component: 'appui-core-input-icon',
            required: false
          }, {
            name: "location",
            title: bbn._("Location"),
            component: 'appui-option-input-location',
            required: true
          }, {
            name: "permission",
            title: bbn._("Path"),
            component: 'appui-option-input-access',
            options: (data) => {
              return {
                root: data.location
              }
            },
            centered: false,
            required: true
          }, {
            name: "argument",
            title: bbn._("Argument"),
            required: false
          }
        ],
        root: appui.plugins['appui-menu'] + '/',
        cf: null,
        data: data,
        currentData: {},
        currentValue: null,
        indexes: Object.keys(data)
      }
    },
    methods: {
      success(){
        bbn.fn.log("SUCCESS", arguments)
      }
    }
  }
})();