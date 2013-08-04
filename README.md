Attribute based flat-rates for magento
======================================

This extensions adds a new shipping-method to magento. The shipping cost can be defined *per-product* for a specific country.  
The calculation-logic will always apply the maximum rate found in the attributes of the products in the cart.  

### Example
For example if you ship to Germany, Great Britain, France and Austria the naming conventions of the attributes would be:  
`shipping_cost_de`, `shipping_cost_gb` and `shipping_cost_fr`. If you dont specify an attribute for a country, for example Austria, Magento will not provide this shipping method.  
  
Now you have several products where you can specify shipping cost for Germany, Great Britain and France. Example:  
- Product A:
    - `shipping_cost_de`: 10.00
    - `shipping_cost_gb`: 15.00
    - `shipping_cost_fr`: 15.00
- Product B:
    - `shipping_cost_de`: 20.00
    - `shipping_cost_gb`: 25.00
    - `shipping_cost_fr`: 25.00

The customer has both Products,  Product A & Product, in his cart and wants to ship to Great Britain. Now the flat-rate for the whole cart would be `25.00`, because it's the highes cost from the products.

### Installation
You just need to Download all files from this repository and extract them into your Magento root. Be shure to activate the shipping-method in your Magento Backend.

### Configuration
You need to add an custom attribute to your products for every country, you want to ship products at using this shipping-method.  
The naming-conventions are `shipping_cost_COUNTRYCODE`, where `COUNTRYCODE` represents the *lower-case* [Iso 3166 Country Code](http://www.iso.org/iso/country_codes/iso_3166_code_lists/country_names_and_code_elements.htm) of the target country.  
Be shure to add your new attributes to your active attribute-sets. :-)

### No Warranty
No Warranty. Software is provided "as it is". Please double-check if your new shipping method is working properly.
