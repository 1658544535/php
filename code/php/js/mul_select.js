// 纯JS省市区三级联动  
// 2011-11-30 by http://www.cnblogs.com/zjfree  
var addressInit = function(provinceList, _cmbProvince, _cmbCity, _cmbArea, defaultProvince, defaultCity, defaultArea)
{
    var cmbProvince = document.getElementById(_cmbProvince);
    var cmbCity = document.getElementById(_cmbCity);
    var cmbArea = document.getElementById(_cmbArea);
    
    function cmbSelect(cmb, str)
    {
        for(var i=0; i<cmb.options.length; i++)
        {
            if(cmb.options[i].value == str)
            {
                cmb.selectedIndex = i;
                return;
            }
        }
    }
    function cmbAddOption(cmb, str, obj)
    {
        var option = document.createElement("OPTION");
        cmb.options.add(option);
        option.innerText = str;
        option.value = obj.id;
        option.obj = obj;
    }
    
    function changeCity()
    {
        cmbArea.options.length = 0;
        if(cmbCity.selectedIndex == -1)return;
        var item = cmbCity.options[cmbCity.selectedIndex].obj;
        for(var i=0; i<item.child.length; i++)
        {
            cmbAddOption(cmbArea, item.child[i].name, item.child[i]);
        }
        cmbSelect(cmbArea, defaultArea);
    }
    function changeProvince()
    {
        cmbCity.options.length = 0;
        cmbCity.onchange = null;
        if(cmbProvince.selectedIndex == -1)return;
        var item = cmbProvince.options[cmbProvince.selectedIndex].obj;
        for(var i=0; i<item.child.length; i++)
        {
            cmbAddOption(cmbCity, item.child[i].name, item.child[i]);
        }
        cmbSelect(cmbCity, defaultCity);
        changeCity();
        cmbCity.onchange = changeCity;
    }
    
    for(var i=0; i<provinceList.length; i++)
    {
        cmbAddOption(cmbProvince, provinceList[i].name, provinceList[i]);
    }
    cmbSelect(cmbProvince, defaultProvince);
    changeProvince();
    cmbProvince.onchange = changeProvince;
}
