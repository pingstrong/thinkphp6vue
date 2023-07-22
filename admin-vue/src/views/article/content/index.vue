<template>
  <div>
    <el-row :gutter="10">
      <el-col :span="24">
        <el-card shadow="never" class="card">
          <div id="charts_one" style="width: 100%; min-height: 80vh">
            <Search
              size="small"
              :searchVisible="searchVisible"
              :searchData.sync="searchData"
              :searchForm="searchForm"
              @refesh_list="index"
            ></Search>
            <div class="btn-group" style="margin-bottom: 11px">
              <div>
                <PersButton
                  type="success"
                  size="mini"
                  label="添加"
                  icon="fa  el-icon-plus"
                  perms="shop:goods:add"
                  @click="add(ids)"
                ></PersButton>
                <PersButton
                  type="primary"
                  :disabled="single"
                  size="mini"
                  label="编辑"
                  icon="fa  el-icon-edit"
                  perms="shop:goods:update"
                  @click="update(ids)"
                ></PersButton>
                <PersButton
                  type="danger"
                  :disabled="multiple"
                  size="mini"
                  label="删除"
                  icon="fa  el-icon-delete"
                  perms="shop:goods:delete"
                  @click="del(ids)"
                ></PersButton>
                <PersButton
                  type="info"
                  :disabled="single"
                  size="mini"
                  label="查看详情"
                  icon="fa  el-icon-view"
                  perms="shop:goods:index"
                  @click="detail(ids)"
                ></PersButton>
              </div>
              <table-tool
                :searchVisible.sync="searchVisible"
                :fieldList="fieldList"
                @refesh_list="index"
                :searchTool="true"
              ></table-tool>
            </div>
            <el-table
              :row-class-name="rowClass"
              @selection-change="selection"
              @row-click="handleRowClick"
              row-key="id"
              :header-cell-style="{ background: '#eef1f6', color: '#606266' }"
              v-loading="loading"
              ref="multipleTable"
              border
              class="eltable"
              :data="list"
              style="width: 100%"
            >
              <el-table-column
                align="center"
                type="selection"
                width="42"
              ></el-table-column>
              <el-table-column
                align="center"
                type=""
                property="id"
                label="编号"
                width="70"
              >
              </el-table-column>
              <el-table-column
                align="left"
                property="title"
                label="名称"
                width=""
              >
              </el-table-column>
              <el-table-column
                align="center"
                property="cateInfo.title"
                label="分类名称"
                width="75"
              >
              </el-table-column>
              <el-table-column align="center" property="pic" label="封面图">
                <template slot-scope="scope">
                  <div class="demo-image__preview">
                    <el-image
                      style="width: 100px"
                      v-if="scope.row.thumb"
                      class="table_list_pic"
                      :src="scope.row.thumb"
                      :preview-src-list="[scope.row.thumb]"
                    ></el-image>
                  </div>
                </template>
              </el-table-column>
              <el-table-column align="center" property="state" label="状态">
                <template slot-scope="scope">
                  <el-switch
                    @change="updateExt(scope.row, 'state')"
                    :active-value="true"
                    :inactive-value="false"
                    v-model="scope.row.state"
                  ></el-switch>
                </template>
              </el-table-column>
              <el-table-column align="center" property="sortid" label="排序">
                <template class="sort" slot-scope="scope">
                  <el-input
                    type="tel"
                    @blur.stop="updateExt(scope.row, 'sortid')"
                    size="mini"
                    placeholder="排序"
                    v-model="scope.row.sortid"
                  ></el-input>
                </template>
              </el-table-column>
              <el-table-column
                align="center"
                property="created_at"
                label="发布时间"
              >
                <template slot-scope="scope">
                  {{ scope.row.created_at }}
                </template>
              </el-table-column>
              <el-table-column
                :fixed="$store.getters.device !== 'mobile' ? 'right' : false"
                label="操作"
                align="center"
              >
                <template slot-scope="scope">
                  <div v-if="scope.row.id">
                    <PersButton
                      type="primary"
                      size="mini"
                      label="编辑"
                      icon="fa  el-icon-edit"
                      perms="shop:goods:update"
                      @click="update(scope.row)"
                    ></PersButton>
                    <PersButton
                      type="danger"
                      size="mini"
                      label="删除"
                      icon="fa  el-icon-delete"
                      perms="shop:goods:delete"
                      @click="del(scope.row)"
                    ></PersButton>
                  </div>
                </template>
              </el-table-column>
            </el-table>
            <Page
              :total="page_data.total"
              :page.sync="page_data.page"
              :limit.sync="page_data.limit"
              @pagination="index"
            />
          </div>
        </el-card>
      </el-col>
    </el-row>
    <!--添加-->
    <Add
      :show.sync="dialog.addDialogStatus"
      size="small"
      @refesh_list="index"
    ></Add>
    <!--修改-->
    <Update
      :info="updateInfo"
      :show.sync="dialog.updateDialogStatus"
      size="small"
      @refesh_list="index"
    ></Update>
    <!--查看详情-->
    <Detail
      :info="detailInfo"
      :show.sync="dialog.detailDialogStatus"
      size="small"
      @refesh_list="index"
    ></Detail>
  </div>
</template>
<script>
import { index, updateExt, getUpdateInfo, del } from "@/api/content/article";
import { getAll as getCateList } from "@/api/content/article_cate";
import Search from "@/components/common/Search.vue";
import Page from "@/components/common/Page.vue";
import TableTool from "@/components/common/TableTool.vue";
import Add from "./add.vue";
import Update from "./update.vue";
import Detail from "./detail.vue";
import { confirm, param2Obj } from "@/utils/common";
import PersButton from "@/components/PersButton";

export default {
  name: "article",
  components: {
    Search,
    Page,
    TableTool,
    Add,
    Update,
    Detail,
    PersButton,
  },
  data() {
    return {
      dialog: {
        addDialogStatus: false,
        updateDialogStatus: false,
        detailDialogStatus: false,
      },
      fieldList: [
        { lable: "编号", checked: true },
        { lable: "名称", checked: true },
        { lable: "状态", checked: true },
        { lable: "排序", checked: true },
        { lable: "发布时间", checked: true },
      ],
      ids: [],
      single: true,
      multiple: true,
      list: [],
      updateInfo: {},
      detailInfo: {},
      loading: false,
      page_data: {
        limit: 20,
        page: 1,
        total: 20,
      },
      searchVisible: true,
      searchForm: [],
      searchData: {},
      cate_list: [],
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init: async function () {
      let result = await getCateList();
      this.cate_list = result.data.list;
      this.index();
    },
    index() {
      let param = { pageSize: this.page_data.limit, page: this.page_data.page };
      Object.assign(param, { search: this.searchData });
      Object.assign(param, param2Obj(this.$route.fullPath));
      this.loading = true;
      index(param).then((res) => {
        this.list = res.data.list;
        this.page_data.total = res.data.total;
        this.loading = false;
        //if(this.page_data.page == 1){
        this.searchForm = [
          //{type:'treeSelect',label:'所属分类',prop:'class_id',data:res.sql_field_data.class_ids,width:'150px'},
          { type: "input", label: "名称", prop: "title", width: "150px" },
          {
            type: "select",
            label: "状态",
            prop: "state",
            data: [
              { label: "正常", value: true },
              { label: "禁用", value: false },
            ],
            width: "150px",
            value_key: "value",
            label_key: "label",
          },
          {
            type: "select",
            label: "所属分类",
            prop: "cate_id",
            data: this.cate_list,
            width: "150px",
            value_key: "id",
            label_key: "title",
          },
          { type: "datetime", prop: "create_time" },
        ];
        //}
      });
    },
    updateExt(row, field) {
      if (row.id) {
        updateExt({ id: row.id, field: field, value: row[field] + "" }).then(
          (res) => {
            this.$message({ message: "操作成功", type: "success" });
          }
        );
      }
    },
    add() {
      this.dialog.addDialogStatus = true;
    },
    update(row) {
      let id = row.id ? row.id : this.ids.join(",");
      getUpdateInfo({ id: id }).then((res) => {
        if (res.code == 200) {
          this.dialog.updateDialogStatus = true;
          this.updateInfo = res.data;
        }
      });
    },
    del(row) {
      confirm({ content: "确定要操作吗" })
        .then(() => {
          let ids = row.id ? row.id : this.ids.join(",");
          del({ id: ids }).then((res) => {
            this.$message({ message: res.msg, type: "success" });
            this.index();
          });
        })
        .catch(() => {});
    },
    detail(row) {
      this.dialog.detailDialogStatus = true;
      this.detailInfo = { id: row.id ? row.id : this.ids.join(",") };
    },
    selection(selection) {
      this.ids = selection.map((item) => item.id);
      this.single = selection.length != 1;
      this.multiple = !selection.length;
    },
    handleRowClick(row, rowIndex, event) {
      if (event.target.className !== "el-input__inner") {
        this.$refs.multipleTable.toggleRowSelection(row);
      }
    },
    rowClass({ row, rowIndex }) {
      for (let i = 0; i < this.ids.length; i++) {
        if (row.id === this.ids[i]) {
          return "rowLight";
        }
      }
    },
  },
};
</script>
<style  lang="scss">
@import "@/assets/css/common.scss";
</style>