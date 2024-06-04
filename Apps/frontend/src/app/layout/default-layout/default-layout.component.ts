import { Component } from '@angular/core';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { RouterModule } from '@angular/router';
import { Utils } from 'services/utils.service';

@Component({
  selector: 'app-default-layout',
  standalone: true,
  imports: [RouterModule, HeaderComponent, FooterComponent],
  providers: [Utils],
  templateUrl: './default-layout.component.html',
  styleUrl: './default-layout.component.css'
})
export class DefaultLayoutComponent {

  constructor(public utils: Utils) { }
}
