<div class="bbn-w-100 bbn-c">
  <bbn-fisheye class="bbn-appui-fisheye bbn-large bbn-iblock"
               :removable="true"
               @remove="removeShortcut"
               ref="fisheye"
               :source="shortcuts"
               :fixed-left="leftShortcuts || []"
               :fixed-right="rightShortcuts || []"
               :mobile="isMobile"
               :z-index="6"/>
</div>
