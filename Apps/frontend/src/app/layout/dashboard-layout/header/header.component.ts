import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { LoginModalComponent } from 'app/shared/login-modal/login-modal.component';
import { SignupModalComponent } from 'app/shared/signup-modal/signup-modal.component';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [RouterModule, SignupModalComponent, LoginModalComponent],
  templateUrl: './header.component.html',
  styleUrl: './header.component.css'
})
export class HeaderComponent {

}
