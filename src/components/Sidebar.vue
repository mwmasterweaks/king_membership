<template>
  <div class>
    <sidebar-menu
      id="leftsidebar"
      :menu="menu"
      width="300px"
      :collapsed="true"
      :hideToggle="true"
      class="sidemenu"
    />
  </div>
</template>

<script>
import { SidebarMenu } from "vue-sidebar-menu";
export default {
  components: {
    SidebarMenu
  },
  data() {
    return {
      menu: [
        {
          header: true,
          title: "Main Navigation",
          hiddenOnCollapse: true
        },
        {
          title: "HOME",
          icon: "fas fa-home",
          child: [
            {
              href: "/MyDashboard",
              title: "My Dashboard"
            }
          ]
        },
        {
          title: "APPLICATIONS",
          icon: "fas fa-scroll",
          child: [
            {
              href: "/ApproveApplications",
              title: "Approved Applications"
            },
            {
              href: "/PendingApplications",
              title: "Pending Applications"
            },
            {
              href: "/RejectedApplications",
              title: "Rejected Applications"
            }
          ]
        }
        // {
        //   title: "MANAGEMENT",
        //   icon: "fas fa-user-cog",
        //   child: [
        //     {
        //       href: "/ManageEmployee",
        //       title: "Users"
        //     },

        //     {
        //       href: "/ManageBranch",
        //       title: "Branch"
        //     }
        //   ]
        // }
      ],
      user: {},
      roles: []
    };
  },
  created() {
    this.roles = this.$global.getRoles();
    this.user = this.$global.getUser();
    this.loadMore();
  },
  mounted() {
    // this.$root.$on("Counter", () => {
    //   this.setCount();
    // });
  },
  methods: {
    // setCount() {
    //   this.$http.post("api/member/counter").then(response => {
    //     console.log(response.body);
    //     this.pendingCount = response.body.pending;
    //     this.approvedCount = response.body.approved;
    //     this.rejectedCount = response.body.rejected;
    //   });
    // },
    loadMore() {
      if (this.roles.admin) {
        this.menu[3] = {
          title: "MANAGEMENT",
          icon: "fas fa-user-cog",
          child: [
            {
              href: "/ManageEmployee",
              title: "Users"
            },
            {
              href: "/ManageBranch",
              title: "Branch"
            }
          ]
        };
      }
    }
  }
};
</script>
<style scoped>
@media print {
  .sidemenu {
    visibility: hidden;
  }
}
.sidemenu {
  background: rgb(167, 167, 167);
}
</style>
