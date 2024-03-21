<bbn-form class="bbn-c"
          :source="formSource"
          :action="root + 'actions/' + (formSource.id ? 'item' : 'menu') + '/copy_to'"
          @success="onSuccess"
>
  <div class="bbn-grid-fields bbn-padded">
    <label><?= _("Menu") ?></label>
    <bbn-dropdown :source="menus"
                  v-model="formSource.to"
                  :required="true"
                  source-text="name"
                  source-value="id"
                  placeholder="<?= _('Choose') ?>"
    ></bbn-dropdown>
    <label><?= _("Title") ?>:</label>
    <bbn-input v-model="formSource.text"
               :require="true"
    ></bbn-input>
    <label><?= _('Icon') ?></label>
    <div class="bbn-flex-width bbn-vmiddle">
      <bbn-input v-model="formSource.icon"
                 class="bbn-flex-fill"
      ></bbn-input>
      <i :class="[formSource.icon, 'bbn-hsmargin', 'bbn-box', 'bbn-xspadded', 'bbn-m']"></i>
      <bbn-button @click="listIcon" icon="nf nf-oct-search"><?= _('Icons') ?></bbn-button>
    </div>
  </div>
</bbn-form>
