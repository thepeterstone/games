#!/usr/bin/env python

class Agent:
  state = {}
  model = {}
  rules = []
  action = None

  def run(self, percept):
    self.update_state(percept)
    rule = self.rule_match()
    self.action = rule.action
    return self.action

  def update_state(self, percept):
    # add percept to state, as a result of action
    # update model
    pass

  def rule_match():
    pass
