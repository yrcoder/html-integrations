import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';

import 'froala-editor/js/plugins.pkgd.min.js';
// Expose FroalaEditor instance to window.
declare const require: any;
(window as any).FroalaEditor = require('froala-editor');
import '@wiris/mathtype-froala3';
import { FroalaEditorModule, FroalaViewModule } from 'angular-froala-wysiwyg';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    FroalaEditorModule.forRoot(), FroalaViewModule.forRoot()
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
