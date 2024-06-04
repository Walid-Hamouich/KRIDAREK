import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { DefaultLayoutComponent } from './default-layout.component';
import { HomeComponent } from './home/home.component';
import { NotFoundComponent } from 'app/not-found/not-found.component';
import { AboutUsComponent } from 'app/about-us/about-us.component';
import { ContactUsComponent } from 'app/contact-us/contact-us.component';
import { FAQComponent } from 'app/faq/faq.component';
import { PropertyListComponent } from 'app/property-list/property-list.component';
import { PropertyDetailsComponent } from 'app/property-details/property-details.component';

const routes: Routes = [
  {
    path: "",
    component: DefaultLayoutComponent,
    children: [
      { path: '', component: HomeComponent },
      { path: "about-us", component: AboutUsComponent },
      { path: "contact-us", component: ContactUsComponent },
      { path: "faq", component: FAQComponent },
      { path: "property-details/:id", component: PropertyDetailsComponent },
      { path: "property-list", component: PropertyListComponent },
      { path: '**', component: NotFoundComponent }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class DefaultLayoutRoutingModule { }
