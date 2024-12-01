<bbn-form :source="formSource"
          :action="root + 'actions/menu/create'"
          @success="onSuccess"
>
  <div class="bbn-padding bbn-w-100">
    <bbn-input class="bbn-w-100"
               placeholder="<?= _('Insert the title') ?>"
               v-model="formSource.title"
               required="required"
    ></bbn-input>
  </div>
</bbn-form>
