
/**
 * helper function to check if DOMParser is support
 * @returns {boolean} true if brower support
 */
const support = (function () {
    if (!window.DOMParser) return false;
    const parser = new DOMParser();
    try {
        parser.parseFromString('x', 'text/html');
    } catch (err) {
        return false;
    }
    return true;
})();

/**
 * Convert a template string into HTML DOM nodes
 * @param  {String} str The template string
 * @return {Node}       The template HTML
 */
const stringToHTML = function (str) {
    if (support) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(str, 'text/html');
        return doc.body;
    }

    // Otherwise, fallback to old-school method
    const dom = document.createElement('div');
    dom.innerHTML = str;
    return dom;
};

/**
 *
 * @param {any} attributes
 * @returns {Array} Attributes
 */
const getAttributes = function (attributes) {
    return Array.prototype.map.call(attributes, function (attribute) {
        return {
            att: attribute.name,
            value: attribute.value
        };
    });
};

/**
 * create dom map from node
 *
 * @param {Node} element
 * @param {boolean} isSVG check if node is svg
 * @returns {Array} DOM tree map of element
 */
const createDOMMap = function (element, isSVG=false) {
    return Array.prototype.map.call(element.childNodes, (function (node) {

        const details = {
            content: node.childNodes && node.childNodes.length > 0 ? null : node.textContent,
            atts: node.nodeType !== 1 ? [] : getAttributes(node.attributes),
            type: node.nodeType === 3 ? 'text' : (node.nodeType === 8 ? 'comment' : node.tagName.toLowerCase()),
            node: node
        };

        details.isSVG = isSVG || details.type === 'svg';

        details.children = createDOMMap(node, details.isSVG);

        return details;

    }));
};

/**
 * Create an array map of style names and values
 * @param  {String} styles The styles
 * @return {Array}         The styles
 */
const getStyleMap = function (styles) {
    return styles.split(';').reduce(function (arr, style) {
        if (style.trim().indexOf(':') > 0) {
            const styleArr = style.split(':');
            arr.push({
                name: styleArr[0] ? styleArr[0].trim() : '',
                value: styleArr[1] ? styleArr[1].trim() : ''
            });
        }
        return arr;
    }, []);
};


const removeStyles = function (elem, styles) {
    styles.forEach(function (style) {
        elem.style[style] = '';
    });
};

const changeStyles = function (elem, styles) {
    styles.forEach(function (style) {
        elem.style[style.name] = style.value;
    });
};

const diffStyles = function (elem, styles) {

    // Get style map
    const styleMap = getStyleMap(styles);

    // Get styles to remove
    const remove = Array.prototype.filter.call(elem.style, function (style) {
        let findStyle = styleMap.find(function (newStyle) {
            return newStyle.name === style && newStyle.value === elem.style[style];
        });
        return findStyle === undefined;
    });

    // Add and remove styles
    removeStyles(elem, remove);
    changeStyles(elem, styleMap);

};

/**
 * Add attributes to an element
 * @param {Node}  elem The element
 * @param {Array} atts The attributes to add
 */
const addAttributes = function (elem, atts) {
    atts.forEach(function (attribute) {
        // If the attribute is a class, use className
        // Otherwise, set the attribute
        if (attribute.att === 'class') {
            elem.className = attribute.value;
        } else if (attribute.att === 'style') {
            diffStyles(elem, attribute.value);
        } else {
            elem.setAttribute(attribute.att, attribute.value || true);
        }
    });
}

const removeAttributes = function (elem, atts) {
    atts.forEach(function (attribute) {
        // If the attribute is a class, use className
        // Else if it's style, remove all styles
        // Otherwise, use removeAttribute()
        if (attribute.att === 'class') {
            elem.className = '';
        } else if (attribute.att === 'style') {
            removeStyles(elem, Array.prototype.slice.call(elem.style));
        } else {
            elem.removeAttribute(attribute.att);
        }
    });
};

/**
 * Make an HTML element
 * @param  {Object} elem The element details
 * @return {Node}        The HTML element
 */
const makeElem = function (elem) {

    // Create the element
    let node;
    if (elem.type === 'text') {
        node = document.createTextNode(elem.content);
    } else if (elem.type === 'comment') {
        node = document.createComment(elem.content);
    } else if (elem.isSVG) {
        node = document.createElementNS('http://www.w3.org/2000/svg', elem.type);
    } else {
        node = document.createElement(elem.type);
    }

    // Add attributes
    addAttributes(node, elem.atts);

    // If the element has child nodes, create them
    // Otherwise, add textContent
    if (elem.children.length > 0) {
        elem.children.forEach(function (childElem) {
            node.appendChild(makeElem(childElem));
        });
    } else if (elem.type !== 'text') {
        node.textContent = elem.content;
    }

    return node;

};

/**
 * Diff the attributes on an existing element versus the template
 * @param  {Object} template The new template
 * @param  {Object} existing The existing DOM node
 */
const diffAtts = function (template, existing) {

    // Get attributes to remove
    const remove = existing.atts.filter(function (att) {
        const getAtt = template.atts.find(function (newAtt) {
            return att.att === newAtt.att;
        });
        return getAtt === undefined;
    });

    // Get attributes to change
    const change = template.atts.filter(function (att) {
        const getAtt = find(existing.atts, function (existingAtt) {
            return att.att === existingAtt.att;
        });
        return getAtt === undefined || getAtt.value !== att.value;
    });

    // Add/remove any required attributes
    addAttributes(existing.node, change);
    removeAttributes(existing.node, remove);

};

let times = 0
/**
 * Diff the existing DOM node versus the template
 * @param  {Array} templateMap A DOM tree map of the template content
 * @param  {Array} DOMMap      A DOM tree map of the existing DOM node
 * @param  {Node}  elem        The element to render content into
 */
const diff = function (templateMap, DOMMap, elem) {
    // Remove extra elements in domMap
    let count = DOMMap.length - templateMap.length;
    if (count > 0) {
        for (; count > 0; count--) {
            DOMMap[DOMMap.length - count].node.parentNode.removeChild(DOMMap[DOMMap.length - count].node);
        }

    }

    // Diff each item in the templateMap
    templateMap.forEach(function (node, index) {

        // If element doesn't exist, create it
        if (!DOMMap[index]) {
            elem.appendChild(makeElem(templateMap[index]));
            return;
        }

        // If element is not the same type, replace it with new element
        if (templateMap[index].type !== DOMMap[index].type) {
            DOMMap[index].node.parentNode.replaceChild(makeElem(templateMap[index]), DOMMap[index].node);
            return;
        }

        // If attributes are different, update them
        diffAtts(templateMap[index], DOMMap[index]);

        // If content is different, update it
        if (templateMap[index].content !== DOMMap[index].content) {
            DOMMap[index].node.textContent = templateMap[index].content;
            return;
        }

        // If target element should be empty, wipe it
        if (DOMMap[index].children.length > 0 && node.children.length < 1) {
            DOMMap[index].node.innerHTML = '';
            return;
        }

        // If element is empty build it up
        if (DOMMap[index].children.length < 1 && node.children.length > 0) {
            const fragment = document.createDocumentFragment();
            diff(node.children, DOMMap[index].children, fragment);
            elem.appendChild(fragment);
            return;
        }

        // If there are existing child elements that need to be modified, diff them
        if (node.children.length > 0) {
            diff(node.children, DOMMap[index].children, DOMMap[index].node);
        }

    });
};

