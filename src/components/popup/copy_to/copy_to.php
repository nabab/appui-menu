<bbn-form class="bbn-full-screen bbn-c"
          :source="source"
          :data="destination"
          :action=""
          @success="onSuccess"

>
  <div class="bbn-c b bbn-padded">
    <bbn-dropdown style="width:200px"
                  :source="source.listMenu"
                  v-model="destination"
    ></bbn-dropdown>
  </div>
</bbn-form>



<!-- :action="source.root + 'actions/copy_menu'" -->
