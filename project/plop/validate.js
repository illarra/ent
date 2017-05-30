const validators = {
    required: function (value) {
        return !!value;
    }
};

module.exports = function (...validations) {
    return function (value) {
        for (let i = 0; i < validations.length; i++) {
            let [fn, message] = validations[i];

            if (fn in validators) {
                if (!validators[fn](value)) {
                    return message;
                }
            } else {
                throw new Error(`Unknown validator: ${fn}.`);
            }
        }

        return true;
    };
};
