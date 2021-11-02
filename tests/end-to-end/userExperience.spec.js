/// <reference types="Cypress" />

describe("userExperience", () => { 
	it("should visit Home Page", () => {
		cy.visit("https://joe-smack-symfony.herokuapp.com/");
        cy.get("main").should("have.css","background-image",'url("https://i.ibb.co/LnDRNsm/aliments.jpg")');
	});

    it("should visit list of entrees page", () => {
        cy.get("nav a").eq(1).click();
        cy.reload();
        cy.get(".RC-List");
        cy.get("main").should("have.css","background-image",'url("https://i.ibb.co/SmX65RN/entree.jpg")');
    });

    it("should visit list of plats page", () => {
        cy.get("nav a").eq(2).click();
        cy.get(".RC-List");
        cy.get("main").should("have.css","background-image",'url("https://i.ibb.co/nfRxZL9/plat.jpg")');
    });

    it("should visit list of patisseries page", () => {
        cy.get("nav a").eq(3).click();
        cy.get(".RC-List");
        cy.get("main").should("have.css","background-image",'url("https://i.ibb.co/qW7StB9/patisserie.jpg")');
    });

    it("should visit ajout recette page", () => {
        cy.get("nav a").eq(5).click();
        cy.get("form");
    });

    it('should fill ajout recette form', () => {
        cy.get("select").select("plat");
        cy.get("input").eq(0).type("FakeTitle");
        cy.get("input").eq(1).type(0);
        cy.get("input").eq(2).type(0);
        cy.get("input").eq(3).type(0);
        cy.get("input").eq(4).type("FakeIngredients");
        cy.get("input").eq(6).type("FakeRecette");
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

    it('should login', () => {
        cy.get("form input").eq(0).type("test89215@gmail.com");
        cy.get("form input").eq(1).type("FakePassword");
        cy.get("form button").click();
        cy.get("nav a").eq(7).click();
    });

    it('should delete account', () => {
        cy.get("form input").type("test89215@gmail.com");
        cy.get("form button").click();
        cy.get("form input").eq(0).type("test89215@gmail.com");
        cy.get("form input").eq(1).type("FakePassword");
        cy.get("form button").click();
        cy.get("div").should("have.attr","class","alert-danger");
    });
});