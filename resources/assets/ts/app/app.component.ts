import {Component} from '@angular/core';

@Component({
    selector: 'app',
    template: './app.component.html',
    styles: ['./app.component.css']
})

export class AppComponent {

    ngOnInit(): void {
        console.log('Laravel & Angular with Laravel Mix - App Component');
    }

}