Development Exercise

  The following code is poorly designed and error prone. Refactor the objects below to follow a more SOLID design.
  Keep in mind the fundamentals of MVVM/MVC and Single-responsibility when refactoring.

  Further, the refactored code should be flexible enough to easily allow the addition of different display
    methods, as well as additional read and write methods.

  Feel free to add as many additional classes and interfaces as you see fit.

  Note: Please create a fork of the https://github.com/BrandonLegault/exercise repository and commit your changes
    to your fork. The goal here is not 100% correctness, but instead a glimpse into how you
    approach refactoring/redesigning bad code. Commit often to your fork.

<hr>

## Process Steps:

### 1. Write a test
The first step for us to begin refactoring this code is to write a test(s) to make sure our refactoring steps don't break the behaviour of the program. Since a refactor should maintain the existing behaviour of the code, tests are a must as we will run them after each step to insure our refactor is in a safe state.

### 2. Determine a starting point
With the tests in place, we need to determine where to begin our refactor. Looking at the requirements, we want the program to be open for adding new display, writing, and reading logic. The original state of the program had the type logic for each of these functional groups housed in conditional switch statements. Since switch statements don't leave us in an open state (we would need to modify the switch statement code to add any new behaviour) we should address this conditional implementation. 

### 3. Refactoring code smells
Switch statements are a well known OO code smell, and lucky for us, each code smell comes with a recipe to refactor it. The recipe I chose to refactor these switch statements was _Replace Type Code with State/Strategy_. My reason for picking this recipe (as opposed to _Replace Conditional with Polymorphism_) is that it follows a compositional approach allowing us to create classes with a designated behaviour. For me, I would tend to stay away from inheritance in this case as it may be too early to create a abstraction for a superclass (making changes in the future less flexible).

I addressed each of the conditionals in a similar manner:

1. Create an interface to expose the behaviour intended by each of the types in the conditional.

2. Break the logic in each of the conditionals into a separate class that implements the interface from the first step.

3. Replace the logic in each step of the conditionals with calls to the interface of each of the abstracted classes.

4. Using the factory pattern, create a factory that given a type (and other arguments) returns an instance of a class whose logic is needed for that type.

5. Replace the conditional with a call to the factory to return the instance of the class relating to the given type.

6. Invoke the method defined by the interface on the instance from step 6.

By completing these steps - the `PlayersObject`'s reading, writing, and displaying functionality became open for addition. To add new behaviour, simply: create a new class for the behaviour, make the class implement the expected interface, then add the class to the related factory.

*Note on the factories*: Technically the factories themselves aren’t open for abstraction as we must change the switch statement to add new classes, however this is part of the factory pattern and the benefit is that we keep the logic of determining which object is returned out of the calling location (`PlayersObject`). This also confines this logic to one specific location that can be reused. Also, it isn't so much a conditional splitting up logic as it is a list of classes instances to build.

It's also possible to have these factories work as a hash based system, or register the classes in the factory which would move us away from the conditional implementation. In this case I find the switch statement nice and explicit, making it easy to read.

### 4. MVC state
Once each of the switch statements were replaced with factory calls, the code was easy to reorganize (only by moving the already created classes into different directories, not by making any further refactoring changes) into a structure resembling MVP.

Here is my breakdown of how I see the MVP structure in the code:

*Model* - The services for reading and writing players + the players are what represents the model level to me. These areas focus on querying or persisting the state of players data structures.

*View* - The players displaying code is an easy fit for the view category as it is based on displaying different representations of the players data to users.

*Controller* - To me the controller has always been the `PlayersObject` class. `PlayersObject` handles requests from the user and then dispatches them to the model level and to the view level. It provides an interface for users to interact with the program while abstracting the view and model logic to the levels respectively.

### 5. Future refactoring
I'm well aware that there still exists many other code smells/areas to refactor in the code:

- We haven't abstracted a Player class out and are still relying on a combination of JSON and `stdClass` instances to represent them. We also have the views accessing the player properties directly (this could be broken out into a decorator once we had a Player class).

- The factories parameter lists can be large. We could refactor these again to accept an object representing the data we need (there's also more refactoring recipes to solve this).

- The `PlayersObject` (controller) holds onto references of the string representation and array representation of the players. This is logic that should be in the model level, where an interface is exposed so that the `PlayerObject` can retrieve this data.

- ...

With any refactoring, we need to stop somewhere. In this case, we have met the requirements for opening the code for new display, writing, and reading functionality. We have also restructured the code into an MVP layout. Since the requirements are met, and the code is in better shape then when we first started, I'm happy with stopping here.

