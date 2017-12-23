<bbn-splitter orientation="horizontal">
  <bbn-pane>
    <bbn-tree :source="test"
               :opened="true"
               @select="select"
               :menu="menu"
               :icon-color="color">
    </bbn-tree>
  </bbn-pane>
  <bbn-pane>
    <bbn-tree :source="test"
              :map="transform"
              uid="id"
              root="0">
    </bbn-tree>
  </bbn-pane>
</bbn-splitter>
