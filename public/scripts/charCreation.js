var app = angular.module('charCreationApp', []);

app.filter('calc', function() {
    return function(proficient, type, prof) {
        var get = type==null?0:type;

        var val = Math.floor((get-10)/2);

        if(proficient){
            var prof = $("#proficiency").val();
            prof = prof==0?0:prof;
            val += parseInt(prof);
        }

        return Math.ceil(val);
    };
});

app.filter('floor', function() {
    return function(input) {
        if(input == "")
            return 0;
        return Math.floor(input);
    };
});


// Attacks
app.controller('attacksController', function() {
    var attackList = this;
    attackList.attacks = [
    ];

    attackList.addAttack = function() {
        attackList.attacks.push({name:'', attack:'', damage: '', range: '', ammo: '', used: ''});
    };

    attackList.remove = function(id) {
        attackList.attacks.splice(id, 1);
    };
});

// Proficiencies & Languages
app.controller('profLangController', function() {
    var profLangList = this;
    profLangList.lines = [
    ];

    profLangList.addLine = function() {
        profLangList.lines.push({line: ''});
    };

    profLangList.remove = function(id) {
        profLangList.lines.splice(id, 1);
    };
});

// Feats and traits
app.controller('featTraitController', function() {
    var featsTraits = this;
    featsTraits.list = [
    ];

    featsTraits.addLine = function() {
        featsTraits.list.push({line: ''});
    };

    featsTraits.remove = function(id) {
        featsTraits.list.splice(id, 1);
    };
});

// Inventory & Equipment
app.controller('invEquipController', function() {
    var inventory = this;
    inventory.items = [
    ];

    inventory.addItem = function() {
        inventory.items.push({item: ''});
    };

    inventory.remove = function(id) {
        inventory.items.splice(id, 1);
    };
});