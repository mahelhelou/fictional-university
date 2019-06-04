import $ from 'jquery'

class Search {
    // 1. Describe and create our object
    constructor() {
        this.openButton = $('.js-search-trigger')
        this.closeButton = $('.search-overlay__close')
        this.searchOverlay = $('.search-overlay')
        this.searchField = $('#search-term')
        this.resultsDiv = $('#search-overlay__results')
        this.events()
        this.isOverlayOpen = false
        this.isSpinnerVisible = false
        this.previousValue
        this.typingTimer
    }

    // 2. Events
    events() {
        this.openButton.on('click', this.openOverlay.bind(this))
        this.closeButton.on('click', this.closeOverlay.bind(this))
        $(document).on('keyup', this.keyPressDispatcher.bind(this))
        this.searchField.on('keyup', this.typingLogic.bind(this))
    }

    // 3. Methods
    typingLogic() {
        if (this.searchField.val() != this.previousValue) {
            // setTimeout(function() { console.log('clicked!') }, 2000)
            clearTimeout(this.typingTimer)

            if (this.searchField.val()) {
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.html('<div class="spinner-loader"></div>')
                    this.isSpinnerVisible = true
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 2000)
            } else {
                this.resultsDiv.html('')
                this.isSpinnerVisible = false
            }
        }
        
        this.previousValue = this.searchField.val()
    }

    getResults() {
        this.resultsDiv.html('something will appear here')
        this.isSpinnerVisible = false
    }

    keyPressDispatcher(e) {
        // find any keyCode in the keyboard
        // console.log(e.keyCode)

        if (e.keyCode == 83 && !this.isOverlayOpen && !$('input, textarea').is(':focus')) {
            this.openOverlay()
        }

        if (e.keyCode == 27 && this.isOverlayOpen) {
            this.closeOverlay()
        }
    }

    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active')
        $('body').addClass('body-no-scroll')
        console.log('the open method is just ran')
        this.isOverlayOpen = true
    }

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active')
        $('body').removeClass('body-no-scroll')
        console.log('the close method is just ran')
        this.isOverlayOpen = false
    }

}

export default Search