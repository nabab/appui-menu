<bbn-splitter orientation="horizontal">
  <div>
    <div class="bbn-full-screen">
      <bbn-tree :source="test"
                 :opened="true"
                 @select="select"
                 :menu="menu"
                 :icon-color="color"
                 ></bbn-tree>
    </div>
  </div>
  <div>
    <div class="bbn-full-screen">
      <bbn-tree source="menu/test_tree"
                 :map="transform"
                 uid="id"
                 root="0"
                 ></bbn-tree>
    </div>
  </div>
</bbn-splitter>
