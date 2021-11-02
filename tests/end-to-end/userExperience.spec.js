/// <reference types="Cypress" />

describe("userExperience", () => { 
	it("should visit Home Page", () => {
		cy.visit("https://joe-smack-symfony.herokuapp.com/");
        cy.get("main").should("have.css","background-image",'url("https://i.ibb.co/LnDRNsm/aliments.jpg")');
	});

    it("should visit list of entrees, plats & patisseries pages", () => {
        cy.get("nav a").contains("Entree").click();
        cy.reload();
        cy.get(".RC-List");
        cy.get("main").should("have.css","background-image",'url("https://i.ibb.co/SmX65RN/entree.jpg")');
        cy.get("nav a").contains("Plat").click();
        cy.get(".RC-List");
        cy.get("main").should("have.css","background-image",'url("https://i.ibb.co/nfRxZL9/plat.jpg")');
        cy.get("nav a").contains("Patisserie").click();
        cy.get(".RC-List");
        cy.get("main").should("have.css","background-image",'url("https://i.ibb.co/qW7StB9/patisserie.jpg")');
    });

    it("should visit ajout recette page and validate form without admin account", () => {
        cy.get("nav a").eq(5).click();
        cy.get("form select").select("plat");
        cy.get("form input").eq(0).type("FakeTitle");
        cy.get("form input").eq(1).type(0);
        cy.get("form input").eq(2).type(0);
        cy.get("form input").eq(3).type(0);
        cy.get("form input").eq(4).type("FakeIngredients");
        cy.get("form input").eq(6).type("FakeRecette");
        cy.get("form button").contains("Ajouter").click();
        cy.get("form button").contains("Ajouter").click();
        cy.get("div").should("have.attr","class","alert-danger");
    });

    it('should register', () => {
        cy.get("nav a").eq(6).click();
        cy.get("strong a").contains("Inscrivez-vous").click();
        cy.get("form input").eq(0).type("test89215@gmail.com");
        cy.get("form input").eq(1).type("FakePassword");
        cy.get("form button").click();
        cy.get("div").should("have.attr","class","alert-success");
    });

    it('should verify email', () => {
        cy.visit("https://joe-smack-symfony.herokuapp.com/cypressVerifyAccount191283238912830390128390128902489218401/test89215@gmail.com");
    });

    it('should login & delete account', () => {
        cy.get("nav a").eq(6).click();
        cy.reload();
        cy.get("form input").eq(0).type("test89215@gmail.com");
        cy.get("form input").eq(1).type("FakePassword");
        cy.get("form button").click();
        cy.get("nav a").eq(7).click();
        cy.get("form input").eq(0).type("test89215@gmail.com");
        cy.get("form button").click();
        cy.get("form input").eq(0).type("test89215@gmail.com");
        cy.get("form input").eq(1).type("FakePassword");
        cy.get("form button").click();
        cy.get("div").should("have.attr","class","alert alert-danger");
    });
});