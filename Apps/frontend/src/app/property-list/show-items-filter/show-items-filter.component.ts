import { Component, Input } from '@angular/core';
import { ShowItemsComponent } from './show-items/show-items.component';
import { FilterComponent } from './filter/filter.component';

@Component({
  selector: 'app-show-items-filter',
  standalone: true,
  imports: [ShowItemsComponent, FilterComponent],
  templateUrl: './show-items-filter.component.html',
  styleUrl: './show-items-filter.component.css'
})
export class ShowItemsFilterComponent {
  @Input()
  public announcementsCount!: number;
}
