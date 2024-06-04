import { Component } from '@angular/core';
import CurrentUserService from 'services/currentuser.service';

@Component({
  selector: 'app-title',
  standalone: true,
  imports: [],
  templateUrl: './title.component.html',
  styleUrl: './title.component.css'
})
export class TitleComponent {
  constructor(
    public currentUserService: CurrentUserService
  ) { }
}
