/**
 * Plugin Name: WooCombinator
 * Plugin URI: http://314pixels.hu/
 * Description: This plugin turns boring variation selects to toggleable buttons in WooCommerce
 * Version: 1.0.4
 * Author: vision-px
 * Author URI: http://314pixels.hu/
 */
jQuery(function ($) {
    var classActive = 'woocombo-active';
    var classDisabled = 'woocombo-disabled';
    var $first = $('.woocombo-container:first');
    var allClassActive = classActive;
    var allClassDisabled = classDisabled;
    var ignoreClickDisabled = false;
    var formSelector = 'form.variations_form';
    if ($first.length > 0) {
        allClassActive = (allClassActive + ' ' + $first.attr('data-class-active')).trim();
        allClassDisabled = (allClassDisabled + ' ' + $first.attr('data-class-disabled')).trim();
        ignoreClickDisabled = $first.attr('data-ignore-click-disabled') === '1';
        formSelector = $first.attr('data-form-selector').trim();
    }
    /**
     * Event listener for the variation changed event
     */
    $(document).on('woocommerce_variation_has_changed', formSelector, function () {
    	console.log('In variation change');
        // For all selects ...
        $(this).find('select').each(function () {
            var $select = $(this);
            var $container = $select.parents('.woocombo-container:first');
            // Clear out classes and disable all entities
            $container
                .find('.woocombo-entity')
                .removeClass(allClassActive + ' ' + allClassDisabled)
                .addClass(allClassDisabled);
            // Find the selected option in the select if any
            var opt = $select.find('option:not(.disabled):selected').filter(function () {
                return this.value.length !== 0;
            });
            if (opt.length == 1) {
                var optval = opt.attr('value');
                // Activate the selected entity
                $container
                    .find('.woocombo-entity[data-value="' + optval + '"]')
                    .removeClass(allClassDisabled)
                    .addClass(allClassActive);
            } else {
                // Re-activate every option which present in the select
                $select.find('option:not(.disabled)').each(function () {
                    var optval = $(this).attr('value');
                    $container.find('.woocombo-entity[data-value="' + optval + '"]').removeClass(allClassDisabled);
                });
            }
        });
    });
    /**
     * Handle click on elements
     */
    $(document).on('click', '.woocombo-entity', function (e) {
    	console.log('in woocombo-entity click');
        var clickedEntity = $(this);
        // Get the form
        var $form = clickedEntity.closest(formSelector);
        var container = clickedEntity.parents('.woocombo-container:first');
        var $select = container.find('select');
        // Remove current selection from selects
        $select.find('option:selected').prop('selected', false);
        // Check if the current entity is selected or disabled
        var isActive = clickedEntity.hasClass(classActive);
        var isDisabled = clickedEntity.hasClass(classDisabled);
        if (isDisabled && ignoreClickDisabled) {
            // Ignore click on disabled elements
            e.preventDefault();
            return false;
        }
        // Find all currently active entities
        var actives = $form.find('.woocombo-entity.' + classActive);
        // Reset the current entity: not active and not displayed
        $form.find('.woocombo-entity').removeClass(allClassActive);
        $form.find('.woocombo-entity').removeClass(allClassDisabled);
        if (isDisabled) {
            // Trigger change event on the select
            $form.find('.variations select').val('').change();
            // $form.trigger('reset_data');
            // Re-trigger click event (to re-enable the disabled element)
            if (!clickedEntity.hasClass(classDisabled)) {
                clickedEntity.click();
                // Check if active elements can be re-activated
                actives.each(function () {
                    var activeEntity = $(this);
                    var selectForEntity = activeEntity.parents('.woocombo-container:first').find('select');
                    if (!selectForEntity.is($select)) {
                        var opt = selectForEntity.find('option[value="' + activeEntity.attr('data-value') + '"]:not(.disabled)');
                        if (opt.length > 0) {
                            // Re-activate if an option is found
                            activeEntity.click();
                        }
                    }
                });
            }
        } else {
            var val = clickedEntity.attr('data-value');
            var opt = $select.find('option[value="' + val + '"]:not(.disabled)');
            if (!isActive && opt.length > 0) {
                // Activate clicked entity
                clickedEntity.addClass(allClassActive);
                opt.prop('selected', true);
            }
            $select.change();
        }
        e.preventDefault();
        return false;
    });

    /**
     * Wait some time after page load and trigger the variation changed event
     * to refresh the displayed combination
     */
    setTimeout(function () {
        var $forms = $(formSelector);
        var formSelects = $forms.find('.variations select');
        formSelects.each(function () {
            var thisSelect = $(this);
            thisSelect.trigger('focusin');
            thisSelect.trigger('touchstart');
        });
        $forms.each(function () {
            var thisForm = $(this);
            thisForm.trigger('woocommerce_variation_has_changed');
        });
    }, 100);
}); 