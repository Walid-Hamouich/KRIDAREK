import { Component, Renderer2, OnInit, Inject } from '@angular/core';
import { CommonModule, DOCUMENT } from '@angular/common';
import { NavigationEnd, Router, RouterOutlet } from '@angular/router';
import { Utils } from 'services/utils.service';
import AuthService from 'services/auth.service';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, RouterOutlet],
  providers: [Utils],
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  title = 'KRIDAREK';

  constructor(
    private _renderer2: Renderer2,
    @Inject(DOCUMENT) private _document: Document,
    private router: Router,
    public utils: Utils,
    public authService: AuthService
  ) { }


  ngOnInit(): void {
    this.router.events.subscribe((event) => {
      if (event instanceof NavigationEnd) {
        if (!event.url.match(/^\/dashboard/)) {
          this.authService.checkToken();
        }
      }
    });
  }
}