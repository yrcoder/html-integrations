import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html'
})

export class AppComponent implements OnInit {

  ngOnInit () {
  }

  public options: Object = {
    toolbarButtons: ['bold', 'italic', 'underline','alert', 'align', 'wirisEditor', 'wirisChemistry'],
    toolbarButtonsXS: ['bold', 'italic', 'underline', 'paragraphFormat', 'alert', 'align', 'wirisEditor', 'wirisChemistry'],
    toolbarButtonsSM: ['bold', 'italic', 'underline', 'paragraphFormat', 'alert', 'align', 'wirisEditor', 'wirisChemistry'],
    toolbarButtonsMD: ['bold', 'italic', 'underline', 'paragraphFormat', 'alert', 'align', 'wirisEditor', 'wirisChemistry'],
  };
}
