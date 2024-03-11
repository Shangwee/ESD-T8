### Questions

Inventory Simple Microservice:
- line 104 onwards: update_inventory
    i think need to do some checks before updating inventory, for e.g.
        if prescribe < inventory: can just deduct
        if prescribe > inventory: deduct the remaining inventory to 0
            the remaining amount will also affect the invoice portion