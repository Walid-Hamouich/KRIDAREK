import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-show-items',
  standalone: true,
  imports: [],
  templateUrl: './show-items.component.html',
  styleUrl: './show-items.component.css'
})
export class ShowItemsComponent {
  @Input()
  public announcementsCount!: number;
}
