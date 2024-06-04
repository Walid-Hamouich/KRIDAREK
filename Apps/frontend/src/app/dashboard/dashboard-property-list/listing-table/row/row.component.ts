import { Component, EventEmitter, Input, Output } from '@angular/core';
import { RouterModule } from '@angular/router';
import Announcement from 'models/announcement.interface';
import City from 'models/city.interface';

@Component({
  selector: '[app-row]',
  standalone: true,
  imports: [RouterModule],
  templateUrl: './row.component.html',
  styleUrl: './row.component.css'
})
export class RowComponent {
  @Input()
  public announcement!: Announcement;

  @Output()
  public delete = new EventEmitter<number>();


  public deleteFunc() {
    if (window.confirm("Vous êtes sûre que vous voulez supprimez, cette annonce?!")) {
      this.delete.emit(this.id);
    }
  }

  get id(): number {
    return this.announcement.id;
  }

  get area(): number {
    return this.announcement.area;
  }

  get title(): string {
    return this.announcement.title;
  }

  get images() {
    return this.announcement.images;
  }

  get price(): number {
    return this.announcement.price;
  }

  get createdAt() {
    return new Date(this.announcement.createdAt).toLocaleDateString();
  }

  get property() {
    return this.announcement.property;
  }

  get city(): City {
    return this.announcement.property.city;
  }
}
