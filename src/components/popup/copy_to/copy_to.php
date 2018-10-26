<bbn-form class="bbn-full-screen bbn-c"
          :source="destination"
          :action="source.root + 'actions/copy_menu_to'"
          @success="onSuccess"
          :prefilled="true"
>
    <div class="bbn-padded bbn-c">
      <bbn-dropdown style="width:200px"
                    :source="source.listMenu"
                    v-model="destination.id_parent"
      ></bbn-dropdown>
    </div>
  </div>
</bbn-form>
