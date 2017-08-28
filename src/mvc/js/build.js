(function(){
  return {
    data(){
      return this.source;
    },
    methods: {
      dragStart(node, data){
        console.log("asasa", node.key);
        return true;
      },
      dragEnter(node, data){
        return true;
      },
      dragDropCopy(node, data){
        console.log("ciao", node, data);
        var name_node = node.title;
        console.log("NAMEEEEEEEEEEEEEEE", name_node);
        if( name_node.substring(0, 6) !== "(COPY)"  ){
          console.log("name", name_node.substring(0, 6));
          data.otherNode.copyTo(node, data.hitMode, function(obj){
            console.log("obj", obj);
            obj.title = "(COPY) " + obj.title;
            obj.key = null;
          });
          bbn.fn.log("AAAAAAAAAAAAAAAAnode",node);
        }

      },
      dragDropMove(node, data){
        data.otherNode.moveTo(node, data.hitMode);
      }
    }
  };
})();
