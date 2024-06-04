import { Component, Input, OnInit, Output } from '@angular/core';
import { CardComponent } from '../card/card.component';
import { HttpClient, HttpContext } from '@angular/common/http';
import { response } from 'express';
import { BYPASS_LOGIN } from 'interceptors/auth.interceptor';
import Announcement from 'models/announcement.interface';
import { Utils } from 'services/utils.service';

@Component({
  selector: 'app-cards',
  standalone: true,
  imports: [CardComponent],
  templateUrl: './cards.component.html',
  styleUrl: './cards.component.css'
})
export class CardsComponent {
  @Input()
  public announcements: Announcement[] = [];
}
