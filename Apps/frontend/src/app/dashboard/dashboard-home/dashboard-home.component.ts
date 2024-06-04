import { Component } from '@angular/core';
import { CounterAreaComponent } from './counter-area/counter-area.component';
import { TitleComponent } from './title/title.component';

@Component({
  selector: 'app-dashboard-home',
  standalone: true,
  imports: [CounterAreaComponent, TitleComponent],
  templateUrl: './dashboard-home.component.html',
  styleUrl: './dashboard-home.component.css'
})
export class DashboardHomeComponent {

}
