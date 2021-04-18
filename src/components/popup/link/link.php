<!-- HTML Document -->

<div class="bbn-overlay">
  <bbn-multipart :source="data"
                 @success="success">
	  <bbn-container url="1"
                   :key="0">
      <div class="bbn-overlay bbn-middle">
        <div class="bbn-block">
          <div class="bbn-block bbn-vmiddle"
               style="display: block">
            <h4><?=_('Title')?></h4>
            <bbn-input v-model="data.title"
                       :required="true"/>
          </div>
        </div>
      </div>
    </bbn-container>
	  <bbn-container url="2"
                   :key="1">
      <div class="bbn-overlay bbn-middle">
        <div class="bbn-block">
          <div class="bbn-block bbn-vmiddle"
               style="display: block">
            <h4><?=_('Icon')?></h4>
            <div class="bbn-block bbn-nowrap">
              <bbn-input v-model="data.icon"
                         :readonly="true"/>
              <i v-if="data.icon"
                 :class="[data.icon, 'bbn-hsmargin', 'bbn-box', 'bbn-xspadded', 'bbn-m']"/>
              <bbn-button @click="openListIcons"
                          icon="nf nf-oct-search">
                <?=_('Icons')?>
              </bbn-button>
            </div>
          </div>
        </div>
      </div>
    </bbn-container>
  </bbn-multipart>
</div>