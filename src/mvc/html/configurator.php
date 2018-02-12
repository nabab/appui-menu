<bbn-splitter :orientation="orientation"
              class="appui-menu-constructor-tree">
  <bbn-pane :resizable="true">
    <div class="bbn-flex-height" style="border-right: 1px dotted #CCC">
      <div class="bbn-w-100 k-header" style="height:60px">
        <div class="bbn-full-screen bbn-middle">
          <div class="bbn-flex-width">
            <div style="width: 350px; padding-left: 20px">
              <bbn-dropdown
                style="width:200px"
                ref="listMenus"
                :source="listMenu"
                v-model="currentMenu"
              ></bbn-dropdown>
              <bbn-button @click="clickPrev" title="<?=_('Back menu')?>" v-if="showArrows">
                <i class="fa fa-arrow-left"></i>
              </bbn-button>
              <bbn-button @click="clickNext" title="<?=_('Next menu')?>" v-if="showArrows">
                <i class="fa fa-arrow-right"></i>
              </bbn-button>
            </div>
            <div class="bbn-flex-fill">
              &nbsp;
            </div>
            <div style="width: 230px; padding-right: 20px" class="bbn-r">
              <bbn-button @click="clickCreateMenu" title="<?=_('Create menu')?>">
                <i class='fa fa-folder-o'></i>
              </bbn-button>
              <bbn-button @click="clickCreateLink" title="<?=_('Create link')?>">
                <i class="fa fa-link"></i>
              </bbn-button>
              <bbn-button @click="clickCreateSection" title="<?=_('Create section')?>">
                <i class="fa fa-thumb-tack"></i>
              </bbn-button>
              <bbn-button @click="clickDeleteMenu" title="<?=_('Delete menu')?>">
                <i class='fa fa-trash-o'></i>
              </bbn-button>
              <bbn-button @click="clickRenameMenu" title="<?=_('Rename menu')?>">
                <i class='fa fa-pencil-square-o'></i>
              </bbn-button>
              <bbn-button @click="clickCopyMenu" title="<?=_('Copy menu')?>">
                <i class='fa fa-clone'></i>
              </bbn-button>
            </div>
          </div>
        </div>
      </div>
      <div class="bbn-flex-fill">
        <div v-if="emptyMenuCurrent && (currentMenu != '')"
             class="bbn-flex-height">
          <div class="bbn-flex-fill bbn-middle">
            <div class="bbn-middle">
              <div class="bbn-c">
                <span class="bbn-c" style="font-size: 6.0em"><?=_("Empty")?></span>
                <br>
                <span class="bbn-c" style="font-size: 6.0em"><?=_("menu")?></span>
              </div>
            </div>
          </div>
        </div>
        <div class="bbn-full-screen bbn-padded" v-if="currentMenu">
          <bbn-tree :source="root + 'configurator'"
                    :map="mapMenu"
                    uid="id"
                    :root="currentMenu"
                    :menu="contextMenu"
                    @select="selectMenu"
                    ref="menus"
                    :draggable="true"
                    @dragEnd="moveNode"
          ></bbn-tree>
        </div>
      </div>
    </div>
  </bbn-pane>
  <bbn-pane :resizable="true">
    <bbn-form v-if="selected"
              :source="selected"
              :data="formData"
              ref="form"
              :action="source.root + 'actions/edit' "
              @success="successEditionMenu"
              @cancel="formCancel">
      <div class="bbn-full-screen bbn-hpadded">
        <div class="bbn-flex-height">
          <h1 class="bbn-c" v-text="_('Édition du menu')"></h1>
          <div class="bbn-w-100">
            <div class="bbn-block bbn-w-20" v-text="_('Title')"></div>
            <div class="bbn-block bbn-w-80">
              <bbn-input v-model="selected.text"></bbn-input>
            </div>
            <div class="bbn-nl"> </div>
            <div class="bbn-block bbn-w-20" v-text="_('Icon')"></div>
            <div class="bbn-block bbn-w-80">
              <bbn-input v-model="selected.icon"></bbn-input>
              <i style="margin-left: 5%; margin-right: 5%" :class="selected.icon"></i>
              <bbn-button @click="openListIcons"><?=_('Icons')?></bbn-button>
            </div>
          </div>
          <div class="bbn-nl"> </div>
          <div class="bbn-w-100 bbn-flex-fill">
            <div class="bbn-full-screen" v-if="selected.id_alias">
              <div class="bbn-block bbn-h-100 bbn-w-20" v-text="_('Link')"></div>
              <div class="bbn-block bbn-h-100 bbn-w-80">
                <div class="bbn-full-screen">
                  <div class="bbn-100" style="border: 1px dotted grey">
                    <bbn-tree source="options/permissions"
                              :map="mapPermissions"
                              uid="id"
                              :root="rootPermission"
                              @select="selectPermission"
                              ref="treePermission"
                              :path="selected.path"
                              :menu="getPermissionsContext"
                    ></bbn-tree>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="bbn-nl"> </div>
          <div class="bbn-w-100" v-if="selected.id_alias">
            <div class="bbn-block bbn-w-20" v-text="_('Argument')"></div>
            <div class="bbn-block bbn-w-80">
              <bbn-input v-model="selected.argument"></bbn-input>
            </div>
          </div>
          <div class="bbn-nl"> </div>
        </div>
      </div>
    </bbn-form>
    <div v-else
         class="bbn-full-screen bbn-middle bbn-c">
      <h1 v-html="_('Select or create<br>a menu element<br>to see the form<br>HERE')" style="line-height: 1.4em"></h1>
    </div>
  </bbn-pane>
</bbn-splitter>