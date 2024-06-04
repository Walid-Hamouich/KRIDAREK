import { Component } from '@angular/core';
import { TitleComponent } from './title/title.component';
import { PaymentPackageComponent } from './payment-package/payment-package.component';
import { PaymentInvoiceComponent } from './payment-invoice/payment-invoice.component';

@Component({
  selector: 'app-dashboard-subscription',
  standalone: true,
  imports: [TitleComponent, PaymentPackageComponent, PaymentInvoiceComponent],
  templateUrl: './dashboard-subscription.component.html',
  styleUrl: './dashboard-subscription.component.css'
})
export class DashboardSubscriptionComponent {

}
