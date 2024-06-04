import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { DashboardLayoutComponent } from './dashboard-layout.component';
import { DashboardHomeComponent } from 'app/dashboard/dashboard-home/dashboard-home.component';
import { DashboardAddPropertyComponent } from 'app/dashboard/dashboard-add-property/dashboard-add-property.component';
import { DashboardSubscriptionComponent } from 'app/dashboard/dashboard-subscription/dashboard-subscription.component';
import { DashboardPropertyListComponent } from 'app/dashboard/dashboard-property-list/dashboard-property-list.component';

const routes: Routes = [
  {
    path: '',
    component: DashboardLayoutComponent,
    children: [
      { path: '', component: DashboardHomeComponent },
      { path: 'add-property', component: DashboardAddPropertyComponent },
      { path: 'property-list', component: DashboardPropertyListComponent },
      { path: 'subscription', component: DashboardSubscriptionComponent }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class DashboardLayoutRoutingModule { }
