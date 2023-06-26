$(document).ready(function()
{
    $(document).on('click', ' .MultiSelect', function() {
        const oMultiSelect = new MultiSelector($(this));
        oMultiSelect.show();
    });

    $(document).on('click', ' .MultiSelect .toutCocherSelMul', function() {
        const oMultiSelect = new MultiSelector($(this).closest('.MultiSelect'));
        oMultiSelect.checkAll($(this));
    });

    $(document).on('click', ' .MultiSelect .toutDecocherSelMul', function() {
        const oMultiSelect = new MultiSelector($(this).closest('.MultiSelect'));
        oMultiSelect.unchekAll($(this));
    });

    $(document).on('click', ' #overlay', function() {
        const oMultiSelect = new MultiSelector($('.MultiSelect'));
        oMultiSelect.hide();
    });

    $(document).on('click', '.ctnRowMultiSelect', function(e) {
        const oMultiSelect = new MultiSelector($(this).closest('.MultiSelect'));
        if(e.target.checked === undefined) oMultiSelect.clickInput($(this));
    });


});

class MultiSelector
{
    constructor(oMultiSelector)
    {
        this.oMultiSelect = oMultiSelector;
        this.overlay = new Overlay();
        this.rows = this.getRowSelMul();
    }

    getRowSelMul()
    {
        return this.oMultiSelect.find('.body').find('.ctnRowMultiSelect').not('.hide');
    }

    show()
    {
        this.overlay.overlayShow();
        this.oMultiSelect.find('.ctnMultiSelect').removeClass('hide');
    }

    hide()
    {
        this.overlay.overlayHide();
        this.oMultiSelect.find('.ctnMultiSelect').addClass('hide');
    }

    checkAll()
    {
        $.each(this.rows, function()
        {
            const oInp = $(this).find('input');
            if(!oInp.attr('disabled')) oInp.attr('checked', 'checked');
        });
    }

    unchekAll()
    {
        $.each(this.rows, function()
        {
            const oInp = $(this).find('input');
            if(!oInp.attr('disabled')) oInp.removeAttr('checked');
        });
    }

    getValues()
    {
        let aData = [];
        $.each(this.rows, function(){
            if($(this).find('input').attr('checked')) aData.push(oInp.val());
        });
        return aData;
    }

    clickInput(a)
    {
        let oInp = a.find('input');
        console.log(oInp);
        if(!oInp) return;
        if(oInp.attr('disabled')) return;
        if(oInp.attr('checked')){
            oInp.removeAttr('checked');
            console.log("attr('checked')");
        }
        else{
            oInp.attr('checked', 'checked');
            console.log("attr('not checked')");
        }
    }
}