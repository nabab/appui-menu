<div class="bbn-w-100">
  <bbn-fisheye class="bbn-appui-fisheye bbn-large"
               :removable="true"
               @remove="removeShortcut"
               ref="fisheye"
               :source="shortcuts"
               :fixed-left="leftShortcuts || []"
               :fixed-right="rightShortcuts || []"
               :mobile="isMobile"
               :z-index="6"/>
</div>
