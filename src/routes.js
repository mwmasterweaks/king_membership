import Vue from "vue";
import VueRouter from "vue-router";

import Login from "./components/user/Login.vue";
import MyDashboard from "./components/routes/HOME/MyDashboard.vue";
// -----------------APPLICATIONS-------------
import ApproveApplication from "./components/routes/APPLICATIONS/ApproveApplications.vue";
import PendingApplication from "./components/routes/APPLICATIONS/PendingApplications.vue";
import RejectedApplication from "./components/routes/APPLICATIONS/RejectedApplications.vue";
import PrintPreview from "./components/routes/APPLICATIONS/PrintPreview.vue";
import PrintIDs from "./components/routes/APPLICATIONS/PrintIDs.vue";

// -----------------MANAGEMENT-------------
import Employee from "./components/routes/MANAGEMENT/Employee.vue";
import Branch from "./components/routes/MANAGEMENT/Branch.vue";
import MembershipType from "./components/routes/MANAGEMENT/MembershipType.vue";

// -----------------PROFILE-------------
import Profile from "./components/others/profile.vue";
import AccountSet from "./components/others/accountSetting.vue";
import Help from "./components/others/Help.vue";

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    {
      path: "/login",
      component: Login,
      meta: {
        forVisitors: true
      }
    },
    {
      path: "/home",
      component: MyDashboard,
      meta: {
        forAuth: true
      }
    },
    {
      path: "/",
      component: MyDashboard,
      meta: {
        forAuth: true
      }
    },
    {
      path: "/MyDashboard",
      component: MyDashboard,
      meta: {
        forAuth: true
      }
    },
    {
      path: "/ApproveApplications",
      component: ApproveApplication,
      meta: {
        forAuth: true
      }
    },
    {
      path: "/PendingApplications",
      component: PendingApplication,
      meta: {
        forAuth: true
      }
    },
    {
      path: "/RejectedApplications",
      component: RejectedApplication,
      meta: {
        forAuth: true
      }
    },

    {
      path: "/ManageEmployee",
      component: Employee,
      meta: {
        forAuth: true
      }
    },
    {
      path: "/ManageBranch",
      component: Branch,
      meta: {
        forAuth: true
      }
    },
    {
      path: "/ManageMembershipType",
      component: MembershipType,
      meta: {
        forAuth: true
      }
    },

    {
      path: "/Profile",
      component: Profile,
      meta: {
        forAuth: true
      }
    },

    {
      path: "/AccountSettings",
      component: AccountSet,
      meta: {
        forAuth: true
      }
    },

    // {
    //   path: "/Help",
    //   component: Help,
    //   meta: {
    //     forAuth: true
    //   }
    // },
    {
      path: "/print",
      component: PrintPreview,
      meta: {
        forAuth: true
      }
    },
    {
      path: "/printid/:item/edit",
      component: PrintIDs,
      meta: {
        forAuth: true
      }
    },

    {
      path: "/items/:item/edit",
      component: PrintPreview,
      meta: {
        forAuth: true
      }
    }
  ],

  mode: "history",
  base: "/Membership/"
});

export default router;
