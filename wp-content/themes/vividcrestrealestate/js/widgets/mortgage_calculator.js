(function($) { $(function() { 
    'use strict';
    
    $('.mortgage__calc input, .mortgage__calc select').on('change', function() {
        // Collect variables from form
        var calculator = $(this).parents('.mortgage__calc');
        var mortgageSum = Number(calculator.find('input[name="mortage_sum"]').val());        
        var yearRate = Number(calculator.find('select[name="rate"]').val())
        var period = Number(calculator.find('select[name="amortization_period"]').val());
        var frequency = Number(calculator.find('select[name="payment_frequency"]').val());
        var frequencyTitle = calculator.find('select[name="payment_frequency"] option:selected').html();
        
        // Check params
        if (mortgageSum == 0) {
            return false;
        }
        
        // Calc Values
        var monthRate = yearRate/12; 
        var monthlySum = (mortgageSum*monthRate/100) / (1-Math.pow(1+monthRate/100, -period*12));
        var sum = monthlySum;
        
        if (frequency !== 'monthly') {
            switch (frequency) {
                case 'weekly':
                    sum = monthlySum*12/52;
                    break;
                    
                case 'rapid_weekly':
                    sum = monthlySum*13/52;
                    break;
                    
                case 'biweekly':
                    sum = monthlySum*12/26;
                    break;
                    
                case 'rapid_biweekly':
                    sum = monthlySum*13/26;
                    break;
            }           
        }
        
        // Show result
        calculator.find('h2 strong').html(' $' + sum.toFixed(2) + ' / ' + frequencyTitle + ' ');        
    });
}) })(jQuery)
