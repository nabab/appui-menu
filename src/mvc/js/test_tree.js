(function(){
	return {
    data(){
      return {
        root: this.source.root,
        test: [
          {text: "a", source: [
            {text: "b"},
            {text: "c"},
            {text: "d"},
            {text: "e"}
          ]},
          {text: "b"},
          {text: "c", source: [
            {text: "b"},
            {text: "c"},
            {text: "d", source: [
              {text: "b"},
              {text: "c"},
              {text: "d"},
              {text: "e", source: [
                {text: "b"},
                {text: "c"},
                {text: "d"},
                {text: "e"}
              ]}
            ]},
            {text: "e"}
          ]},
          {text: "d", source: [
            {text: "b"},
            {text: "c"},
            {text: "d"},
            {text: "e"}
          ]},
          {text: "e"}
        ]
      }
    },
    methods: {
      select(tree){
        bbn.fn.log(tree.selectedNode.text + " is selected");
      },
      transform(a){
        return {
          data: a,
          icon: a.icon,
          text: a.text,
          num: a.num_children || 0
        }
      },
      menu(node){
        let m = [{
          text: 'Test',
          click: () => {
            alert('test');
          }
        }];
        if ( node.level ){
          m.push({
            text: 'Check my level',
            click: () => {
              alert('I am in level ' + node.level);
            }
          })
        }
        return m;
      },
      color(node){
        switch ( node.level ){
          case 1:
            return 'green';
          case 2:
            return 'blue';
          case 3:
            return 'red';
          case 4:
            return 'pink';
        }
      }
    }
  }
})();