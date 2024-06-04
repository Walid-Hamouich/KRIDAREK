import { Component, Input } from '@angular/core';
import { RouterModule } from '@angular/router';
import Announcement from 'models/announcement.interface';
import City from 'models/city.interface';

@Component({
  selector: 'app-card',
  standalone: true,
  imports: [RouterModule],
  templateUrl: './card.component.html',
  styleUrl: './card.component.css'
})
export class CardComponent {
  @Input()
  public announcement!: Announcement;

  get title(): string {
    return this.announcement.title;
  }

  get slug(): string {
    return this.announcement.slug;
  }

  get price(): number {
    return this.announcement.price;
  }

  get area(): number {
    return this.announcement.area;
  }

  get images(): string[] {
    return this.announcement.images;
  }

  get city(): City {
    return this.announcement.property.city;
  }

  get id(): number {
    return this.announcement.id
  }
}
